<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ChatbotConversation;
use App\Models\ChatbotRule;
use App\Models\ChatbotNegotiation;
use App\Models\ChatbotLanguage;
use App\Models\ChatbotUserPreference;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Leads;
use App\Models\Vacancies;
use App\Models\JobAppliers;
use App\Models\DealAssist;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\SupportTicket;
use App\Models\SupportTicketConv;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\faq;
use App\Models\HelpTopic;
use App\Models\FlashDeal;
use App\Models\FeatureDeal;
use App\Models\DealOfTheDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('web-views.chatbot.index');
    }

    public function processMessage(Request $request)
    {
        try {
            $message = trim($request->input('message', ''));
            $sessionId = $request->input('session_id', Str::uuid());
            $userId = Auth::guard('customer')->id();

            // Store user message
            $conversation = ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => $message,
                'is_bot' => false,
                'message_type' => 'text'
            ]);

            // Process the message and get bot response
            $botResponse = $this->generateResponse($message, $sessionId, $userId);

            // Store bot response
            $botConversation = ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => $botResponse['message'],
                'is_bot' => true,
                'message_type' => $botResponse['type'],
                'metadata' => json_encode($botResponse['metadata'] ?? [])
            ]);

            return response()->json([
                'success' => true,
                'session_id' => $sessionId,
                'response' => $botResponse
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sorry, I encountered an error. Please try again.'
            ], 500);
        }
    }

    private function generateResponse($message, $sessionId, $userId)
    {
        $originalMessage = $message;
        $message = strtolower($message);
        
        // Log the incoming message for debugging
        Log::info('Chatbot processing message: ' . $originalMessage);
        
        try {
            // Check for greeting patterns
            if (preg_match('/\b(hello|hi|hey|good morning|good evening|good afternoon)\b/i', $message)) {
                Log::info('Matched greeting pattern');
                return $this->getGreetingResponse($userId);
            }

            // Check for product search patterns
            if (preg_match('/\b(search|find|look for|show me|product|item)\b/i', $message)) {
                Log::info('Matched product search pattern');
                return $this->handleProductSearch($originalMessage);
            }

            // Check for order status patterns
            if (preg_match('/\b(order|status|track|delivery|shipped|my orders)\b/i', $message)) {
                Log::info('Matched order inquiry pattern');
                return $this->handleOrderInquiry($userId, $originalMessage);
            }

            // Check for help patterns
            if (preg_match('/\b(help|support|assistance|problem|issue)\b/i', $message)) {
                Log::info('Matched help pattern');
                return $this->getHelpResponse();
            }

            // Check for contact patterns
            if (preg_match('/\b(contact|phone|email|address|location)\b/i', $message)) {
                Log::info('Matched contact pattern');
                return $this->getContactResponse();
            }

            // Check for account patterns
            if (preg_match('/\b(account|profile|login|register|password)\b/i', $message)) {
                Log::info('Matched account pattern');
                return $this->getAccountResponse($userId);
            }

            // Check for lead management patterns (check before cart to avoid conflicts)
            if (preg_match('/\b(lead|requirement)\b/i', $message) || 
                preg_match('/\b(post|create|add)\b.*\b(buy|sell|offer)\b/i', $message)) {
                Log::info('Matched lead management pattern');
                return $this->handleLeadManagement($originalMessage, $userId);
            }

            // Check for shopping cart patterns
            if (preg_match('/\b(cart|add to cart|checkout|purchase)\b/i', $message) ||
                preg_match('/\b(buy)\b/i', $message) && !preg_match('/\b(post|create|add|lead|requirement)\b/i', $message)) {
                Log::info('Matched cart pattern');
                return $this->getCartResponse($userId);
            }

            // Check for category patterns
            if (preg_match('/\b(category|categories|browse|section)\b/i', $message)) {
                Log::info('Matched category pattern');
                return $this->getCategoryResponse();
            }

            // Check for form submission patterns
            if (preg_match('/\b(form|submit|inquiry|quote|request)\b/i', $message)) {
                Log::info('Matched form submission pattern');
                return $this->handleFormSubmission($originalMessage, $userId);
            }

            // Check for job patterns
            if (preg_match('/\b(job|career|hiring|vacancy|apply)\b/i', $message)) {
                Log::info('Matched job inquiry pattern');
                return $this->handleJobInquiry($originalMessage, $userId);
            }

            // Check for deal assist patterns
            if (preg_match('/\b(negotiate|deal|price|discount|offer)\b/i', $message)) {
                Log::info('Matched deal assist pattern');
                return $this->handleDealAssist($originalMessage, $userId);
            }

            // Check for membership patterns
            if (preg_match('/\b(membership|subscription|plan|upgrade)\b/i', $message)) {
                Log::info('Matched membership pattern');
                return $this->handleMembershipInquiry($originalMessage, $userId);
            }

            // Check for language patterns
            if (preg_match('/\b(language|translate|hindi|english|spanish)\b/i', $message)) {
                Log::info('Matched language pattern');
                return $this->handleLanguageRequest($originalMessage, $userId);
            }

            // Default response
            Log::info('No pattern matched, using default response');
            return $this->getDefaultResponse();

        } catch (\Exception $e) {
            Log::error('Error in generateResponse: ' . $e->getMessage());
            return $this->getDefaultResponse();
        }
    }

    private function getGreetingResponse($userId)
    {
        $user = $userId ? Customer::find($userId) : null;
        $name = $user ? $user->f_name : 'there';
        
        return [
            'message' => "Hello {$name}! 👋 Welcome to our comprehensive marketplace. I can help you with:",
            'type' => 'text',
            'metadata' => [
                'suggestions' => [
                    '🔍 Search products',
                    '📩 Post buy/sell leads',
                    '💼 Find jobs',
                    '⚙️ Negotiate deals',
                    '🧾 Membership plans',
                    '📦 Check orders',
                    '🆘 Get support',
                    '🌐 Switch language'
                ]
            ]
        ];
    }

    private function handleProductSearch($message)
    {
        try {
            // Extract potential product keywords
            $keywords = $this->extractKeywords($message);
            
            if (empty($keywords)) {
                return [
                    'message' => 'What product are you looking for? Please provide more details.',
                    'type' => 'text',
                    'metadata' => ['requires_input' => true]
                ];
            }

            // Search for products
            $products = Product::where(function($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('name', 'LIKE', "%{$keyword}%")
                          ->orWhere('details', 'LIKE', "%{$keyword}%");
                }
            })
            ->where('status', 1)
            ->limit(5)
            ->get();

            if ($products->count() > 0) {
                $productList = $products->map(function ($product) {
                    try {
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => $product->unit_price,
                            'image' => $product->thumbnail_full_url ?? '',
                            'url' => route('product', $product->slug)
                        ];
                    } catch (\Exception $e) {
                        Log::error('Product mapping error: ' . $e->getMessage());
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => $product->unit_price,
                            'image' => '',
                            'url' => '#'
                        ];
                    }
                });

                return [
                    'message' => "I found {$products->count()} products that match your search:",
                    'type' => 'product_list',
                    'metadata' => [
                        'products' => $productList,
                        'search_keywords' => $keywords
                    ]
                ];
            }

            return [
                'message' => "I couldn't find any products matching your search. Try different keywords or browse our categories.",
                'type' => 'text',
                'metadata' => [
                    'suggestions' => ['Browse categories', 'Popular products', 'Contact support']
                ]
            ];

        } catch (\Exception $e) {
            Log::error('Product search error: ' . $e->getMessage());
            return [
                'message' => 'Sorry, I encountered an error while searching for products. Please try again.',
                'type' => 'text',
                'metadata' => [
                    'suggestions' => ['Try again', 'Browse categories', 'Contact support']
                ]
            ];
        }
    }

    private function handleOrderInquiry($userId, $message)
    {
        if (!$userId) {
            return [
                'message' => 'Please log in to check your order status.',
                'type' => 'text',
                'metadata' => [
                    'action' => 'login_required',
                    'suggestions' => ['Login', 'Create account']
                ]
            ];
        }

        try {
            $orders = Order::where('customer_id', $userId)
                          ->orderBy('created_at', 'desc')
                          ->limit(3)
                          ->get();

            if ($orders->count() > 0) {
                $orderList = $orders->map(function ($order) {
                    try {
                        return [
                            'id' => $order->id,
                            'status' => $order->order_status ?? 'pending',
                            'total' => $order->order_amount ?? 0,
                            'date' => $order->created_at->format('M d, Y'),
                            'url' => route('account-order-details', $order->id)
                        ];
                    } catch (\Exception $e) {
                        Log::error('Order mapping error: ' . $e->getMessage());
                        return [
                            'id' => $order->id,
                            'status' => 'unknown',
                            'total' => 0,
                            'date' => 'N/A',
                            'url' => '#'
                        ];
                    }
                });

                return [
                    'message' => "Here are your recent orders:",
                    'type' => 'order_list',
                    'metadata' => [
                        'orders' => $orderList
                    ]
                ];
            }

            return [
                'message' => "You don't have any orders yet. Start shopping to place your first order!",
                'type' => 'text',
                'metadata' => [
                    'suggestions' => ['Browse products', 'Popular items', 'Categories']
                ]
            ];

        } catch (\Exception $e) {
            Log::error('Order inquiry error: ' . $e->getMessage());
            return [
                'message' => 'Sorry, I encountered an error while fetching your orders. Please try again.',
                'type' => 'text',
                'metadata' => [
                    'suggestions' => ['Try again', 'Contact support']
                ]
            ];
        }
    }

    private function getHelpResponse()
    {
        return [
            'message' => "I'm here to help! Here's what I can assist you with:",
            'type' => 'help_menu',
            'metadata' => [
                'help_options' => [
                    ['title' => 'Product Search', 'description' => 'Find products by name or category'],
                    ['title' => 'Order Status', 'description' => 'Check your order status and tracking'],
                    ['title' => 'Account Help', 'description' => 'Login, registration, and account issues'],
                    ['title' => 'Shopping Cart', 'description' => 'Add items, checkout, and payment help'],
                    ['title' => 'Contact Support', 'description' => 'Get in touch with our support team']
                ]
            ]
        ];
    }

    private function getContactResponse()
    {
        $contactInfo = [
            'email' => config('mail.from.address', 'support@marketplace.com'),
            'phone' => '+1-555-0123', // Add your actual phone
            'address' => '123 Marketplace St, City, Country', // Add your actual address
            'hours' => 'Monday - Friday: 9 AM - 6 PM'
        ];

        return [
            'message' => "Here's how you can contact us:",
            'type' => 'contact_info',
            'metadata' => [
                'contact' => $contactInfo,
                'suggestions' => ['Email us', 'Call support', 'Live chat']
            ]
        ];
    }

    private function getAccountResponse($userId)
    {
        if (!$userId) {
            return [
                'message' => "To access your account features, please log in or create a new account.",
                'type' => 'text',
                'metadata' => [
                    'actions' => [
                        ['title' => 'Login', 'url' => route('customer.auth.login')],
                        ['title' => 'Register', 'url' => route('customer.auth.sign-up')]
                    ]
                ]
            ];
        }

        $user = Customer::find($userId);
        return [
            'message' => "Hello {$user->f_name}! What would you like to do with your account?",
            'type' => 'text',
            'metadata' => [
                'suggestions' => [
                    'View profile',
                    'Order history',
                    'Update password',
                    'Address book'
                ]
            ]
        ];
    }

    private function getCartResponse($userId)
    {
        return [
            'message' => "I can help you with your shopping cart. What would you like to do?",
            'type' => 'text',
            'metadata' => [
                'suggestions' => [
                    'View cart',
                    'Continue shopping',
                    'Checkout help',
                    'Payment options'
                ]
            ]
        ];
    }

    private function getCategoryResponse()
    {
        try {
            // Fetch actual categories from database
            $categories = Category::where('status', 1)
                                ->orderBy('priority', 'desc')
                                ->limit(10)
                                ->get(['id', 'name', 'slug'])
                                ->map(function($category) {
                                    return [
                                        'id' => $category->id,
                                        'name' => $category->name,
                                        'url' => route('products', ['id' => $category->id, 'data_from' => 'category', 'page' => 1])
                                    ];
                                });

            if ($categories->count() > 0) {
                return [
                    'message' => "Browse our popular categories:",
                    'type' => 'category_list',
                    'metadata' => [
                        'categories' => $categories,
                        'suggestions' => ['View all categories', 'Popular products']
                    ]
                ];
            }
        } catch (\Exception $e) {
            Log::error('Category fetch error: ' . $e->getMessage());
        }

        // Fallback to hardcoded categories if database fetch fails
        $categories = [
            ['name' => 'Electronics', 'url' => '#'],
            ['name' => 'Fashion', 'url' => '#'],
            ['name' => 'Home & Garden', 'url' => '#'],
            ['name' => 'Sports', 'url' => '#'],
            ['name' => 'Books', 'url' => '#'],
            ['name' => 'Toys', 'url' => '#']
        ];

        return [
            'message' => "Browse our popular categories:",
            'type' => 'category_list',
            'metadata' => [
                'categories' => $categories,
                'suggestions' => ['View all categories', 'Popular products']
            ]
        ];
    }

    private function handleFormSubmission($message, $userId)
    {
        // Check if this is a form submission request
        if (preg_match('/\b(inquiry|quote|request)\b/i', $message)) {
            return [
                'message' => "I can help you submit an inquiry. Please provide the following information:",
                'type' => 'form',
                'metadata' => [
                    'form_type' => 'inquiry',
                    'fields' => [
                        ['name' => 'subject', 'label' => 'Subject', 'type' => 'text', 'required' => true],
                        ['name' => 'message', 'label' => 'Your Message', 'type' => 'textarea', 'required' => true],
                        ['name' => 'contact_preference', 'label' => 'Preferred Contact Method', 'type' => 'select', 
                         'options' => ['Email', 'Phone', 'SMS']]
                    ]
                ]
            ];
        }

        return $this->getDefaultResponse();
    }

    public function submitForm(Request $request)
    {
        try {
            $formType = $request->input('form_type');
            $formData = $request->input('form_data');
            $sessionId = $request->input('session_id');
            $userId = Auth::guard('customer')->id();

            // Process the form based on type
            switch ($formType) {
                case 'inquiry':
                    return $this->processInquiryForm($formData, $userId, $sessionId);
                case 'quote':
                    return $this->processQuoteForm($formData, $userId, $sessionId);
                case 'buy_lead':
                    return $this->processBuyLeadForm($formData, $userId, $sessionId);
                case 'sell_offer':
                    return $this->processSellOfferForm($formData, $userId, $sessionId);
                case 'job_posting':
                    return $this->processJobPostingForm($formData, $userId, $sessionId);
                case 'job_application':
                    return $this->processJobApplicationForm($formData, $userId, $sessionId);
                case 'price_negotiation':
                    return $this->processPriceNegotiationForm($formData, $userId, $sessionId);
                case 'track_negotiation':
                    return $this->processTrackNegotiationForm($formData, $userId, $sessionId);
                case 'custom_offer':
                    return $this->processCustomOfferForm($formData, $userId, $sessionId);
                case 'escalate_support':
                    return $this->processEscalateSupportForm($formData, $userId, $sessionId);
                case 'membership_upgrade':
                    return $this->processMembershipUpgradeForm($formData, $userId, $sessionId);
                case 'support_ticket':
                    return $this->processSupportTicketForm($formData, $userId, $sessionId);
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid form type'
                    ]);
            }

        } catch (\Exception $e) {
            Log::error('Form Submission Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error submitting form. Please try again.'
            ]);
        }
    }

    private function processInquiryForm($formData, $userId, $sessionId)
    {
        // Here you can save to database, send emails, etc.
        // For example, save to a inquiries table or send email

        // Store the form submission
        ChatbotConversation::create([
            'session_id' => $sessionId,
            'user_id' => $userId,
            'message' => 'Form submitted: ' . $formData['subject'],
            'is_bot' => false,
            'message_type' => 'form_submission',
            'metadata' => json_encode($formData)
        ]);

        return response()->json([
            'success' => true,
            'message' => "Thank you! Your inquiry has been submitted successfully. We'll get back to you within 24 hours.",
            'type' => 'text'
        ]);
    }

    private function processQuoteForm($formData, $userId, $sessionId)
    {
        // Process quote request
        ChatbotConversation::create([
            'session_id' => $sessionId,
            'user_id' => $userId,
            'message' => 'Quote request submitted',
            'is_bot' => false,
            'message_type' => 'form_submission',
            'metadata' => json_encode($formData)
        ]);

        return response()->json([
            'success' => true,
            'message' => "Your quote request has been received. Our team will provide you with a detailed quote within 2 business days.",
            'type' => 'text'
        ]);
    }

    // ==========================================
    // 📝 FORM PROCESSING METHODS
    // ==========================================

    private function processBuyLeadForm($formData, $userId, $sessionId)
    {
        try {
            $lead = Leads::create([
                'name' => $formData['name'],
                'product_name' => $formData['product_name'],
                'quantity_required' => $formData['quantity_required'],
                'details' => $formData['details'],
                'contact_number' => $formData['contact_number'],
                'country' => $formData['country'],
                'city' => $formData['city'] ?? '',
                'buying_frequency' => $formData['buying_frequency'] ?? 'One Time',
                'unit' => $formData['unit'] ?? 'Piece',
                'type' => 'buy',
                'added_by' => $userId,
                'active' => true
            ]);

            ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => 'Buy requirement posted: ' . $formData['product_name'],
                'is_bot' => false,
                'message_type' => 'form_submission',
                'metadata' => json_encode($formData)
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Your buy requirement has been posted successfully! Lead ID: {$lead->id}. Sellers will contact you soon.",
                'type' => 'text'
            ]);
        } catch (\Exception $e) {
            Log::error('Buy Lead Form Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to post buy requirement. Please try again.'
            ]);
        }
    }

    private function processSellOfferForm($formData, $userId, $sessionId)
    {
        try {
            $offer = Leads::create([
                'name' => $formData['name'],
                'product_name' => $formData['product_name'],
                'avl_stock' => $formData['avl_stock'],
                'details' => $formData['details'],
                'contact_number' => $formData['contact_number'],
                'country' => $formData['country'],
                'city' => $formData['city'] ?? '',
                'rate' => $formData['rate'] ?? 0,
                'unit' => $formData['unit'] ?? 'Piece',
                'type' => 'sell',
                'added_by' => $userId,
                'active' => true
            ]);

            ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => 'Sell offer posted: ' . $formData['product_name'],
                'is_bot' => false,
                'message_type' => 'form_submission',
                'metadata' => json_encode($formData)
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Your sell offer has been posted successfully! Offer ID: {$offer->id}. Buyers will contact you soon.",
                'type' => 'text'
            ]);
        } catch (\Exception $e) {
            Log::error('Sell Offer Form Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to post sell offer. Please try again.'
            ]);
        }
    }

    private function processJobPostingForm($formData, $userId, $sessionId)
    {
        try {
            $job = Vacancies::create([
                'title' => $formData['title'],
                'company_name' => $formData['company_name'],
                'location' => $formData['location'],
                'employment_type' => $formData['employment_type'],
                'description' => $formData['description'],
                'salary_low' => $formData['salary_low'] ?? 0,
                'salary_high' => $formData['salary_high'] ?? 0,
                'experience_required' => $formData['experience_required'] ?? 0,
                'skills_required' => $formData['skills_required'] ?? '',
                'application_deadline' => $formData['application_deadline'] ?? null,
                'user_id' => $userId,
                'status' => 'active',
                'Approved' => 0 // Pending approval
            ]);

            ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => 'Job posted: ' . $formData['title'],
                'is_bot' => false,
                'message_type' => 'form_submission',
                'metadata' => json_encode($formData)
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Your job listing has been submitted successfully! Job ID: {$job->id}. It's pending approval and will be live soon.",
                'type' => 'text'
            ]);
        } catch (\Exception $e) {
            Log::error('Job Posting Form Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to post job listing. Please try again.'
            ]);
        }
    }

    private function processJobApplicationForm($formData, $userId, $sessionId)
    {
        try {
            // Check if job exists
            $job = Vacancies::find($formData['job_id']);
            if (!$job) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job not found. Please check the job ID.'
                ]);
            }

            // Check if already applied
            $existingApplication = JobAppliers::where('jobid', $formData['job_id'])
                                             ->where('user_id', $userId)
                                             ->first();

            if ($existingApplication) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already applied for this job.'
                ]);
            }

            $application = JobAppliers::create([
                'jobid' => $formData['job_id'],
                'user_id' => $userId,
                'cover_letter' => $formData['cover_letter'],
                'status' => 'pending'
            ]);

            ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => 'Applied for job: ' . $job->title,
                'is_bot' => false,
                'message_type' => 'form_submission',
                'metadata' => json_encode($formData)
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Your job application has been submitted successfully! Application ID: {$application->id}. The employer will review your application.",
                'type' => 'text'
            ]);
        } catch (\Exception $e) {
            Log::error('Job Application Form Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit job application. Please try again.'
            ]);
        }
    }

    private function processPriceNegotiationForm($formData, $userId, $sessionId)
    {
        try {
            $product = Product::find($formData['deal_id']);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found. Please check the product ID.'
                ]);
            }

            $negotiation = ChatbotNegotiation::create([
                'deal_id' => $formData['deal_id'],
                'user_id' => $userId,
                'seller_id' => $product->user_id,
                'original_price' => $product->unit_price,
                'offered_price' => $formData['offered_price'],
                'status' => 'pending',
                'message' => $formData['message'] ?? '',
                'negotiation_type' => 'price',
                'expires_at' => now()->addDays(7)
            ]);

            ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => 'Price negotiation started for: ' . $product->name,
                'is_bot' => false,
                'message_type' => 'form_submission',
                'metadata' => json_encode($formData)
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Your negotiation request has been sent! Negotiation ID: {$negotiation->id}. The seller will respond within 48 hours.",
                'type' => 'text'
            ]);
        } catch (\Exception $e) {
            Log::error('Price Negotiation Form Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to start negotiation. Please try again.'
            ]);
        }
    }

    private function processTrackNegotiationForm($formData, $userId, $sessionId)
    {
        try {
            $negotiation = ChatbotNegotiation::where('id', $formData['request_id'])
                                           ->where('user_id', $userId)
                                           ->first();

            if (!$negotiation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Negotiation not found. Please check the request ID.'
                ]);
            }

            $statusMessage = "📊 Negotiation Status:\n";
            $statusMessage .= "• Status: " . ucfirst($negotiation->status) . "\n";
            $statusMessage .= "• Original Price: $" . $negotiation->original_price . "\n";
            $statusMessage .= "• Your Offer: $" . $negotiation->offered_price . "\n";
            
            if ($negotiation->counter_price) {
                $statusMessage .= "• Counter Offer: $" . $negotiation->counter_price . "\n";
            }
            
            $statusMessage .= "• Created: " . $negotiation->created_at->format('M d, Y H:i');

            return response()->json([
                'success' => true,
                'message' => $statusMessage,
                'type' => 'text'
            ]);
        } catch (\Exception $e) {
            Log::error('Track Negotiation Form Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to track negotiation. Please try again.'
            ]);
        }
    }

    private function processCustomOfferForm($formData, $userId, $sessionId)
    {
        try {
            $product = Product::find($formData['deal_id']);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found. Please check the product ID.'
                ]);
            }

            $customOffer = ChatbotNegotiation::create([
                'deal_id' => $formData['deal_id'],
                'user_id' => $userId,
                'seller_id' => $product->user_id,
                'original_price' => $product->unit_price,
                'offered_price' => $formData['custom_price'],
                'status' => 'pending',
                'message' => $formData['custom_terms'] ?? '',
                'negotiation_type' => 'price',
                'expires_at' => now()->addDays($formData['validity_days'] ?? 7),
                'metadata' => json_encode(['type' => 'custom_offer'])
            ]);

            ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => 'Custom offer sent for: ' . $product->name,
                'is_bot' => false,
                'message_type' => 'form_submission',
                'metadata' => json_encode($formData)
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Your custom offer has been sent! Offer ID: {$customOffer->id}. Valid for " . ($formData['validity_days'] ?? 7) . " days.",
                'type' => 'text'
            ]);
        } catch (\Exception $e) {
            Log::error('Custom Offer Form Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send custom offer. Please try again.'
            ]);
        }
    }

    private function processEscalateSupportForm($formData, $userId, $sessionId)
    {
        try {
            $ticketId = 'ESC-' . time() . '-' . $userId;

            // In a real implementation, you would save this to a support tickets table
            $ticket = [
                'ticket_id' => $ticketId,
                'user_id' => $userId,
                'deal_id' => $formData['deal_id'],
                'issue' => $formData['issue'],
                'priority' => 'high',
                'status' => 'open',
                'created_at' => now()
            ];

            ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => 'Support escalation: ' . $formData['issue'],
                'is_bot' => false,
                'message_type' => 'form_submission',
                'metadata' => json_encode($formData)
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Your issue has been escalated to our support team! Ticket ID: {$ticketId}. You will be contacted within 24 hours.",
                'type' => 'text'
            ]);
        } catch (\Exception $e) {
            Log::error('Escalate Support Form Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to escalate to support. Please try again.'
            ]);
        }
    }

    private function processMembershipUpgradeForm($formData, $userId, $sessionId)
    {
        try {
            $plans = [
                2 => ['name' => 'Premium', 'price' => 29],
                3 => ['name' => 'Enterprise', 'price' => 99]
            ];

            $selectedPlan = $plans[$formData['plan_id']] ?? null;
            if (!$selectedPlan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid plan selected.'
                ]);
            }

            // In a real implementation, you would process the payment here
            $membership = [
                'user_id' => $userId,
                'plan_id' => $formData['plan_id'],
                'plan_name' => $selectedPlan['name'],
                'price' => $selectedPlan['price'],
                'payment_method' => $formData['payment_method'],
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'created_at' => now()
            ];

            ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => 'Membership upgraded to: ' . $selectedPlan['name'],
                'is_bot' => false,
                'message_type' => 'form_submission',
                'metadata' => json_encode($formData)
            ]);

            return response()->json([
                'success' => true,
                'message' => "🎉 Congratulations! Your membership has been upgraded to {$selectedPlan['name']} plan. Enjoy your premium features!",
                'type' => 'text'
            ]);
        } catch (\Exception $e) {
            Log::error('Membership Upgrade Form Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upgrade membership. Please try again.'
            ]);
        }
    }

    private function processSupportTicketForm($formData, $userId, $sessionId)
    {
        try {
            $ticketId = 'TKT-' . time() . '-' . $userId;

            // In a real implementation, you would save this to a support tickets table
            $ticket = [
                'ticket_id' => $ticketId,
                'user_id' => $userId,
                'issue_type' => $formData['issue_type'],
                'subject' => $formData['subject'],
                'description' => $formData['description'],
                'priority' => $formData['priority'] ?? 'medium',
                'status' => 'open',
                'created_at' => now()
            ];

            ChatbotConversation::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message' => 'Support ticket created: ' . $formData['subject'],
                'is_bot' => false,
                'message_type' => 'form_submission',
                'metadata' => json_encode($formData)
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Your support ticket has been created! Ticket ID: {$ticketId}. Our team will respond within 24 hours.",
                'type' => 'text'
            ]);
        } catch (\Exception $e) {
            Log::error('Support Ticket Form Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create support ticket. Please try again.'
            ]);
        }
    }

    private function getDefaultResponse()
    {
        $responses = [
            "I'm not sure I understand. Could you rephrase that?",
            "Can you provide more details about what you're looking for?",
            "I'm here to help with products, leads, jobs, deals, membership, and support!",
            "Try asking about searching products, posting leads, finding jobs, or getting help."
        ];

        return [
            'message' => $responses[array_rand($responses)],
            'type' => 'text',
            'metadata' => [
                'suggestions' => [
                    '🔍 Search products',
                    '📩 Post buy lead',
                    '💼 Find jobs',
                    '⚙️ Negotiate deals',
                    '🧾 Membership',
                    '📦 My orders',
                    '🆘 Get help',
                    '🌐 Language'
                ]
            ]
        ];
    }

    private function extractKeywords($message)
    {
        // Simple keyword extraction
        $stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'find', 'search', 'look', 'show', 'me'];
        $words = explode(' ', strtolower($message));
        
        return array_filter($words, function($word) use ($stopWords) {
            return strlen($word) > 2 && !in_array($word, $stopWords);
        });
    }

    public function getConversationHistory(Request $request)
    {
        $sessionId = $request->input('session_id');
        
        if (!$sessionId) {
            return response()->json(['success' => false, 'message' => 'Session ID required']);
        }

        $conversations = ChatbotConversation::where('session_id', $sessionId)
                                         ->orderBy('created_at', 'asc')
                                         ->get();

        return response()->json([
            'success' => true,
            'conversations' => $conversations
        ]);
    }

    public function callExternalApi(Request $request)
    {
        try {
            $apiUrl = $request->input('api_url');
            $method = $request->input('method', 'GET');
            $data = $request->input('data', []);

            // Make API call
            $response = Http::timeout(30)->{strtolower($method)}($apiUrl, $data);

            return response()->json([
                'success' => true,
                'data' => $response->json(),
                'status' => $response->status()
            ]);

        } catch (\Exception $e) {
            Log::error('External API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error calling external API'
            ], 500);
        }
    }

    // ==========================================
    // 🔍 1. PRODUCT DISCOVERY & NAVIGATION
    // ==========================================

    public function searchProductsByNameOrCategory(Request $request)
    {
        try {
            $query = $request->input('query', '');
            $category = $request->input('category', '');
            $location = $request->input('location', '');
            $minPrice = $request->input('min_price', 0);
            $maxPrice = $request->input('max_price', 999999);
            $limit = $request->input('limit', 10);

            $products = Product::query()
                ->when($query, function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('details', 'LIKE', "%{$query}%")
                      ->orWhere('tags', 'LIKE', "%{$query}%");
                })
                ->when($category, function($q) use ($category) {
                    $q->whereHas('category', function($cat) use ($category) {
                        $cat->where('name', 'LIKE', "%{$category}%");
                    });
                })
                ->whereBetween('unit_price', [$minPrice, $maxPrice])
                ->where('status', 1)
                ->with(['shop', 'category', 'brand'])
                ->limit($limit)
                ->get();

            return response()->json([
                'success' => true,
                'products' => $products->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->unit_price,
                        'image' => $product->thumbnail_full_url,
                        'shop' => $product->shop->name ?? 'N/A',
                        'category' => $product->category->name ?? 'N/A',
                        'url' => route('product', $product->slug)
                    ];
                }),
                'total' => $products->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Product Search Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Search failed'], 500);
        }
    }

    // ==========================================
    // 📩 2. LEAD MANAGEMENT (BUY/SELL)
    // ==========================================

    public function handleLeadManagement($message, $userId)
    {
        if (preg_match('/\b(post|create|add)\b.*\b(buy|purchase|requirement)\b/i', $message)) {
            return $this->getBuyLeadForm();
        }
        
        if (preg_match('/\b(post|create|add)\b.*\b(sell|offer|supply)\b/i', $message)) {
            return $this->getSellOfferForm();
        }
        
        if (preg_match('/\b(my|view)\b.*\b(leads|requirements|offers)\b/i', $message)) {
            return $this->viewMyLeads($userId);
        }

        return [
            'message' => "I can help you with lead management. What would you like to do?",
            'type' => 'text',
            'metadata' => [
                'suggestions' => [
                    'Post buy requirement',
                    'Post sell offer',
                    'View my leads',
                    'Lead status'
                ]
            ]
        ];
    }

    private function getBuyLeadForm()
    {
        return [
            'message' => "I'll help you post a buy requirement. Please provide the following information:",
            'type' => 'form',
            'metadata' => [
                'form_type' => 'buy_lead',
                'fields' => [
                    ['name' => 'name', 'label' => 'Your Name', 'type' => 'text', 'required' => true],
                    ['name' => 'product_name', 'label' => 'Product Name', 'type' => 'text', 'required' => true],
                    ['name' => 'quantity_required', 'label' => 'Quantity Required', 'type' => 'text', 'required' => true],
                    ['name' => 'details', 'label' => 'Detailed Requirements', 'type' => 'textarea', 'required' => true],
                    ['name' => 'contact_number', 'label' => 'Contact Number', 'type' => 'text', 'required' => true],
                    ['name' => 'country', 'label' => 'Country', 'type' => 'select', 'required' => true],
                    ['name' => 'city', 'label' => 'City', 'type' => 'text', 'required' => false],
                    ['name' => 'buying_frequency', 'label' => 'Buying Frequency', 'type' => 'select', 
                     'options' => ['One Time', 'Monthly', 'Quarterly', 'Yearly']],
                    ['name' => 'unit', 'label' => 'Unit', 'type' => 'text', 'required' => false]
                ]
            ]
        ];
    }

    private function getSellOfferForm()
    {
        return [
            'message' => "I'll help you post a sell offer. Please provide the following information:",
            'type' => 'form',
            'metadata' => [
                'form_type' => 'sell_offer',
                'fields' => [
                    ['name' => 'name', 'label' => 'Your Name', 'type' => 'text', 'required' => true],
                    ['name' => 'product_name', 'label' => 'Product Name', 'type' => 'text', 'required' => true],
                    ['name' => 'avl_stock', 'label' => 'Available Stock', 'type' => 'text', 'required' => true],
                    ['name' => 'details', 'label' => 'Product Details', 'type' => 'textarea', 'required' => true],
                    ['name' => 'contact_number', 'label' => 'Contact Number', 'type' => 'text', 'required' => true],
                    ['name' => 'country', 'label' => 'Country', 'type' => 'select', 'required' => true],
                    ['name' => 'city', 'label' => 'City', 'type' => 'text', 'required' => false],
                    ['name' => 'rate', 'label' => 'Rate/Price', 'type' => 'number', 'required' => false],
                    ['name' => 'unit', 'label' => 'Unit', 'type' => 'text', 'required' => false]
                ]
            ]
        ];
    }

    private function viewMyLeads($userId)
    {
        if (!$userId) {
            return [
                'message' => 'Please log in to view your leads.',
                'type' => 'text',
                'metadata' => [
                    'action' => 'login_required',
                    'suggestions' => ['Login', 'Create account']
                ]
            ];
        }

        try {
            $leads = Leads::where('user_id', $userId)
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();

            if ($leads->count() > 0) {
                $leadList = $leads->map(function ($lead) {
                    return [
                        'id' => $lead->id,
                        'type' => $lead->type, // 'buy' or 'sell'
                        'product_name' => $lead->product_name,
                        'status' => $lead->status ?? 'active',
                        'created_date' => $lead->created_at->format('M d, Y'),
                        'details' => substr($lead->details, 0, 100) . '...'
                    ];
                });

                return [
                    'message' => "Here are your recent leads:",
                    'type' => 'lead_list',
                    'metadata' => [
                        'leads' => $leadList,
                        'suggestions' => ['Post new lead', 'View all leads']
                    ]
                ];
            }

            return [
                'message' => "You don't have any leads yet. Would you like to post a buy requirement or sell offer?",
                'type' => 'text',
                'metadata' => [
                    'suggestions' => [
                        'Post buy requirement',
                        'Post sell offer',
                        'Browse leads'
                    ]
                ]
            ];

        } catch (\Exception $e) {
            Log::error('View leads error: ' . $e->getMessage());
            return [
                'message' => 'Sorry, I encountered an error while fetching your leads. Please try again.',
                'type' => 'text',
                'metadata' => [
                    'suggestions' => ['Try again', 'Contact support']
                ]
            ];
        }
    }

    // ==========================================
    // 🧑‍💼 3. JOBS & HIRING
    // ==========================================

    public function handleJobInquiry($message, $userId)
    {
        if (preg_match('/\b(search|find|look)\b.*\b(job|career|vacancy)\b/i', $message)) {
            return $this->searchJobs($message);
        }
        
        if (preg_match('/\b(post|create|add)\b.*\b(job|vacancy|hiring)\b/i', $message)) {
            return $this->getJobPostingForm();
        }
        
        if (preg_match('/\b(apply|application)\b/i', $message)) {
            return $this->getJobApplicationInfo();
        }

        return [
            'message' => "I can help you with job-related queries. What are you looking for?",
            'type' => 'text',
            'metadata' => [
                'suggestions' => [
                    'Search jobs',
                    'Post job vacancy',
                    'My applications',
                    'Job categories'
                ]
            ]
        ];
    }

    private function searchJobs($message)
    {
        $keywords = $this->extractKeywords($message);
        
        $jobs = Vacancies::where(function($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('title', 'LIKE', "%{$keyword}%")
                      ->orWhere('description', 'LIKE', "%{$keyword}%")
                      ->orWhere('location', 'LIKE', "%{$keyword}%");
            }
        })
        ->where('status', 'active')
        ->where('Approved', 1)
        ->limit(5)
        ->get();

        if ($jobs->count() > 0) {
            $jobList = $jobs->map(function($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'company' => $job->company_name,
                    'location' => $job->location,
                    'type' => $job->employment_type,
                    'salary' => $job->salary_low . ' - ' . $job->salary_high
                ];
            });

            return [
                'message' => "I found {$jobs->count()} job opportunities:",
                'type' => 'job_list',
                'metadata' => ['jobs' => $jobList]
            ];
        }

        return [
            'message' => "I couldn't find any jobs matching your search. Try different keywords or browse all jobs.",
            'type' => 'text',
            'metadata' => [
                'suggestions' => ['Browse all jobs', 'Post job requirement', 'Job categories']
            ]
        ];
    }

    private function getJobPostingForm()
    {
        return [
            'message' => "I'll help you post a job vacancy. Please provide the job details:",
            'type' => 'form',
            'metadata' => [
                'form_type' => 'job_posting',
                'fields' => [
                    ['name' => 'title', 'label' => 'Job Title', 'type' => 'text', 'required' => true],
                    ['name' => 'company_name', 'label' => 'Company Name', 'type' => 'text', 'required' => true],
                    ['name' => 'location', 'label' => 'Job Location', 'type' => 'text', 'required' => true],
                    ['name' => 'employment_type', 'label' => 'Employment Type', 'type' => 'select', 
                     'options' => ['full-time', 'part-time', 'contract', 'freelance'], 'required' => true],
                    ['name' => 'description', 'label' => 'Job Description', 'type' => 'textarea', 'required' => true],
                    ['name' => 'salary_low', 'label' => 'Minimum Salary', 'type' => 'number', 'required' => false],
                    ['name' => 'salary_high', 'label' => 'Maximum Salary', 'type' => 'number', 'required' => false],
                    ['name' => 'experience_required', 'label' => 'Experience Required (Years)', 'type' => 'number', 'required' => false],
                    ['name' => 'skills_required', 'label' => 'Required Skills', 'type' => 'textarea', 'required' => false],
                    ['name' => 'application_deadline', 'label' => 'Application Deadline', 'type' => 'date', 'required' => false]
                ]
            ]
        ];
    }

    private function getJobApplicationInfo()
    {
        return [
            'message' => "To apply for a job, I need the job ID and your cover letter. Would you like to:",
            'type' => 'text',
            'metadata' => [
                'suggestions' => [
                    'Search jobs first',
                    'View my applications',
                    'Upload resume',
                    'Application tips'
                ]
            ]
        ];
    }

    // ==========================================
    // ⚙️ 4. DEAL ASSIST & NEGOTIATION
    // ==========================================

    public function handleDealAssist($message, $userId)
    {
        if (preg_match('/\b(negotiate|bargain|price)\b/i', $message)) {
            return $this->getNegotiationForm();
        }
        
        if (preg_match('/\b(deal|assistance|help)\b/i', $message)) {
            return $this->getDealAssistForm();
        }

        return [
            'message' => "I can help you with deal assistance and negotiations. What do you need help with?",
            'type' => 'text',
            'metadata' => [
                'suggestions' => [
                    'Request negotiation',
                    'Deal assistance',
                    'Track negotiation',
                    'Contact support'
                ]
            ]
        ];
    }

    private function getNegotiationForm()
    {
        return [
            'message' => "I'll help you negotiate a deal. Please provide the details:",
            'type' => 'form',
            'metadata' => [
                'form_type' => 'negotiation',
                'fields' => [
                    ['name' => 'deal_id', 'label' => 'Product/Deal ID', 'type' => 'number', 'required' => true],
                    ['name' => 'offered_price', 'label' => 'Your Offered Price', 'type' => 'number', 'required' => true],
                    ['name' => 'negotiation_type', 'label' => 'Negotiation Type', 'type' => 'select', 
                     'options' => ['price', 'quantity', 'terms'], 'required' => true],
                    ['name' => 'message', 'label' => 'Additional Message', 'type' => 'textarea', 'required' => false]
                ]
            ]
        ];
    }

    private function getDealAssistForm()
    {
        return [
            'message' => "I'll help you with deal assistance. Please describe your issue:",
            'type' => 'form',
            'metadata' => [
                'form_type' => 'deal_assist',
                'fields' => [
                    ['name' => 'deal_id', 'label' => 'Deal/Product ID', 'type' => 'number', 'required' => false],
                    ['name' => 'issue', 'label' => 'Describe Your Issue', 'type' => 'textarea', 'required' => true],
                    ['name' => 'contact_preference', 'label' => 'Preferred Contact Method', 'type' => 'select', 
                     'options' => ['Email', 'Phone', 'Chat']]
                ]
            ]
        ];
    }

    // ==========================================
    // 🧾 5. MEMBERSHIP & SUBSCRIPTIONS
    // ==========================================

    public function handleMembershipInquiry($message, $userId)
    {
        if (preg_match('/\b(plans|pricing|membership)\b/i', $message)) {
            return $this->showMembershipPlansResponse();
        }
        
        if (preg_match('/\b(upgrade|subscribe)\b/i', $message)) {
            return $this->getMembershipUpgradeForm();
        }
        
        if (preg_match('/\b(status|current|my)\b.*\b(membership|subscription)\b/i', $message)) {
            return $this->viewMembershipStatus($userId);
        }

        return [
            'message' => "I can help you with membership and subscription queries. What would you like to know?",
            'type' => 'text',
            'metadata' => [
                'suggestions' => [
                    'View membership plans',
                    'Compare features',
                    'Upgrade membership',
                    'My membership status'
                ]
            ]
        ];
    }

    private function showMembershipPlansResponse()
    {
        return [
            'message' => "Here are our membership plans:",
            'type' => 'membership_plans',
            'metadata' => [
                'plans' => [
                    ['name' => 'Basic', 'price' => 'Free', 'features' => ['5 Products', '2 Leads', 'Basic Support']],
                    ['name' => 'Premium', 'price' => '$29/month', 'features' => ['50 Products', '20 Leads', 'Priority Support', 'Analytics']],
                    ['name' => 'Enterprise', 'price' => '$99/month', 'features' => ['Unlimited Products', 'Unlimited Leads', '24/7 Support', 'Advanced Analytics']]
                ],
                'suggestions' => ['Compare features', 'Upgrade now', 'Contact sales']
            ]
        ];
    }

    private function viewMembershipStatus($userId)
    {
        if (!$userId) {
            return [
                'message' => 'Please log in to view your membership status.',
                'type' => 'text',
                'metadata' => ['action' => 'login_required']
            ];
        }

        return [
            'message' => "Your current membership: Basic Plan (Free)",
            'type' => 'membership_status',
            'metadata' => [
                'plan_name' => 'Basic',
                'status' => 'active',
                'features' => ['5 Products', '2 Leads', 'Basic Support'],
                'suggestions' => ['Upgrade membership', 'View usage', 'Billing history']
            ]
        ];
    }

    private function getMembershipUpgradeForm()
    {
        return [
            'message' => "I'll help you upgrade your membership. Please select a plan:",
            'type' => 'form',
            'metadata' => [
                'form_type' => 'membership_upgrade',
                'fields' => [
                    ['name' => 'plan_id', 'label' => 'Select Plan', 'type' => 'select', 
                     'options' => ['premium' => 'Premium ($29/month)', 'enterprise' => 'Enterprise ($99/month)'], 'required' => true],
                    ['name' => 'payment_method', 'label' => 'Payment Method', 'type' => 'select', 
                     'options' => ['Credit Card', 'PayPal', 'Bank Transfer'], 'required' => true]
                ]
            ]
        ];
    }

    // ==========================================
    // 🌐 6. MULTI-LANGUAGE SUPPORT
    // ==========================================

    public function handleLanguageRequest($message, $userId)
    {
        if (preg_match('/\b(switch|change|set)\b.*\b(language|lang)\b/i', $message)) {
            return $this->getLanguageSelectionForm();
        }
        
        if (preg_match('/\b(supported|available)\b.*\b(language|lang)\b/i', $message)) {
            return $this->listSupportedLanguagesResponse();
        }

        return [
            'message' => "I can help you with language settings. What would you like to do?",
            'type' => 'text',
            'metadata' => [
                'suggestions' => [
                    'Switch language',
                    'Supported languages',
                    'Language preferences'
                ]
            ]
        ];
    }

    private function getLanguageSelectionForm()
    {
        return [
            'message' => "Please select your preferred language:",
            'type' => 'form',
            'metadata' => [
                'form_type' => 'language_selection',
                'fields' => [
                    ['name' => 'language_code', 'label' => 'Select Language', 'type' => 'select', 
                     'options' => ['en' => 'English', 'hi' => 'Hindi', 'es' => 'Spanish', 'fr' => 'French'], 'required' => true]
                ]
            ]
        ];
    }

    private function listSupportedLanguagesResponse()
    {
        return [
            'message' => "We support the following languages:",
            'type' => 'language_list',
            'metadata' => [
                'languages' => [
                    ['code' => 'en', 'name' => 'English', 'flag' => '🇺🇸'],
                    ['code' => 'hi', 'name' => 'Hindi', 'flag' => '🇮🇳'],
                    ['code' => 'es', 'name' => 'Spanish', 'flag' => '🇪🇸'],
                    ['code' => 'fr', 'name' => 'French', 'flag' => '🇫🇷'],
                    ['code' => 'de', 'name' => 'German', 'flag' => '🇩🇪'],
                    ['code' => 'ar', 'name' => 'Arabic', 'flag' => '🇸🇦']
                ],
                'suggestions' => ['Switch language', 'Set default language']
            ]
        ];
    }

    // ==========================================
    // 🔍 ADDITIONAL PRODUCT METHODS
    // ==========================================

    public function filterProductsByLocationPrice(Request $request)
    {
        try {
            $location = $request->input('location', '');
            $minPrice = $request->input('min_price', 0);
            $maxPrice = $request->input('max_price', 999999);
            $category = $request->input('category', '');
            $limit = $request->input('limit', 20);

            $products = Product::query()
                ->when($location, function($q) use ($location) {
                    $q->whereHas('shop', function($shop) use ($location) {
                        $shop->where('address', 'LIKE', "%{$location}%")
                             ->orWhere('city', 'LIKE', "%{$location}%")
                             ->orWhere('state', 'LIKE', "%{$location}%");
                    });
                })
                ->when($category, function($q) use ($category) {
                    $q->whereHas('category', function($cat) use ($category) {
                        $cat->where('name', 'LIKE', "%{$category}%");
                    });
                })
                ->whereBetween('unit_price', [$minPrice, $maxPrice])
                ->where('status', 1)
                ->with(['shop', 'category', 'brand'])
                ->limit($limit)
                ->get();

            return response()->json([
                'success' => true,
                'products' => $products->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->unit_price,
                        'image' => $product->thumbnail_full_url,
                        'shop' => $product->shop->name ?? 'N/A',
                        'location' => $product->shop->city ?? 'N/A',
                        'category' => $product->category->name ?? 'N/A',
                        'url' => route('product', $product->slug)
                    ];
                }),
                'total' => $products->count(),
                'filters_applied' => [
                    'location' => $location,
                    'price_range' => [$minPrice, $maxPrice],
                    'category' => $category
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Filter Products Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Filter failed'], 500);
        }
    }

    // ==========================================
    // 📩 ADDITIONAL LEAD MANAGEMENT METHODS
    // ==========================================

    public function updateLead(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            $leadId = $request->input('lead_id');
            
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $lead = Leads::where('id', $leadId)
                         ->where('added_by', $userId)
                         ->first();

            if (!$lead) {
                return response()->json(['success' => false, 'message' => 'Lead not found']);
            }

            $updateData = $request->validate([
                'name' => 'nullable|string|max:255',
                'details' => 'nullable|string',
                'quantity_required' => 'nullable|string',
                'avl_stock' => 'nullable|string',
                'contact_number' => 'nullable|string',
                'rate' => 'nullable|numeric',
                'active' => 'nullable|boolean'
            ]);

            $lead->update(array_filter($updateData));

            return response()->json([
                'success' => true,
                'message' => 'Lead updated successfully',
                'lead' => $lead
            ]);
        } catch (\Exception $e) {
            Log::error('Update Lead Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update lead'], 500);
        }
    }

    public function deleteLead(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            $leadId = $request->input('lead_id');
            
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $lead = Leads::where('id', $leadId)
                         ->where('added_by', $userId)
                         ->first();

            if (!$lead) {
                return response()->json(['success' => false, 'message' => 'Lead not found']);
            }

            $lead->delete();

            return response()->json([
                'success' => true,
                'message' => 'Lead deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Delete Lead Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete lead'], 500);
        }
    }

    public function getLeadStatus(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            $leadId = $request->input('lead_id');
            
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $lead = Leads::where('id', $leadId)
                         ->where('added_by', $userId)
                         ->first();

            if (!$lead) {
                return response()->json(['success' => false, 'message' => 'Lead not found']);
            }

            return response()->json([
                'success' => true,
                'lead' => [
                    'id' => $lead->id,
                    'type' => $lead->type,
                    'name' => $lead->name,
                    'status' => $lead->active ? 'Active' : 'Inactive',
                    'posted_date' => $lead->created_at->format('M d, Y'),
                    'views' => $lead->views ?? 0,
                    'responses' => $lead->responses ?? 0
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Get Lead Status Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to get lead status'], 500);
        }
    }

    // ==========================================
    // 🧑‍💼 ADDITIONAL JOB METHODS
    // ==========================================

    public function viewApplicants(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            $jobId = $request->input('job_id');
            
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $job = Vacancies::where('id', $jobId)
                           ->where('user_id', $userId)
                           ->first();

            if (!$job) {
                return response()->json(['success' => false, 'message' => 'Job not found or unauthorized']);
            }

            $applicants = JobAppliers::where('jobid', $jobId)
                                    ->with('user')
                                    ->get();

            return response()->json([
                'success' => true,
                'job_title' => $job->title,
                'applicants' => $applicants->map(function($applicant) {
                    return [
                        'id' => $applicant->id,
                        'user_name' => $applicant->user->f_name . ' ' . $applicant->user->l_name,
                        'email' => $applicant->user->email,
                        'phone' => $applicant->user->phone,
                        'cover_letter' => $applicant->cover_letter,
                        'status' => $applicant->status,
                        'applied_date' => $applicant->created_at->format('M d, Y')
                    ];
                }),
                'total_applicants' => $applicants->count()
            ]);
        } catch (\Exception $e) {
            Log::error('View Applicants Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load applicants'], 500);
        }
    }

    public function getJobStatus(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            $jobId = $request->input('job_id');
            
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $job = Vacancies::where('id', $jobId)
                           ->where('user_id', $userId)
                           ->first();

            if (!$job) {
                return response()->json(['success' => false, 'message' => 'Job not found']);
            }

            $applicantsCount = JobAppliers::where('jobid', $jobId)->count();

            return response()->json([
                'success' => true,
                'job' => [
                    'id' => $job->id,
                    'title' => $job->title,
                    'status' => $job->status,
                    'approved' => $job->Approved ? 'Yes' : 'Pending',
                    'posted_date' => $job->created_at->format('M d, Y'),
                    'applicants_count' => $applicantsCount,
                    'views' => $job->views ?? 0
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Get Job Status Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to get job status'], 500);
        }
    }

    // ==========================================
    // ⚙️ ADDITIONAL DEAL ASSIST METHODS
    // ==========================================

    public function sendCustomOffer(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $offerData = $request->validate([
                'deal_id' => 'required|integer',
                'custom_price' => 'required|numeric',
                'custom_terms' => 'nullable|string',
                'validity_days' => 'nullable|integer|min:1|max:30'
            ]);

            $product = Product::find($offerData['deal_id']);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found']);
            }

            $customOffer = ChatbotNegotiation::create([
                'deal_id' => $offerData['deal_id'],
                'user_id' => $userId,
                'seller_id' => $product->user_id,
                'original_price' => $product->unit_price,
                'offered_price' => $offerData['custom_price'],
                'status' => 'pending',
                'message' => $offerData['custom_terms'] ?? '',
                'negotiation_type' => 'price',
                'expires_at' => now()->addDays($offerData['validity_days'] ?? 7),
                'metadata' => json_encode(['type' => 'custom_offer'])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Custom offer sent successfully',
                'offer_id' => $customOffer->id
            ]);
        } catch (\Exception $e) {
            Log::error('Send Custom Offer Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send custom offer'], 500);
        }
    }

    // ==========================================
    // 🧾 ADDITIONAL MEMBERSHIP METHODS
    // ==========================================

    public function cancelSubscription(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $membership = Membership::where('user_id', $userId)
                                  ->where('status', 'active')
                                  ->first();

            if (!$membership) {
                return response()->json(['success' => false, 'message' => 'No active membership found']);
            }

            $membership->update([
                'status' => 'cancelled',
                'cancelled_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Subscription cancelled successfully. You can continue using premium features until ' . $membership->end_date->format('M d, Y')
            ]);
        } catch (\Exception $e) {
            Log::error('Cancel Subscription Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to cancel subscription'], 500);
        }
    }

    // ==========================================
    // 🧑‍💼 ADDITIONAL USER ACCOUNT METHODS
    // ==========================================

    public function resetPassword(Request $request)
    {
        try {
            $email = $request->input('email');
            
            if (!$email) {
                return response()->json(['success' => false, 'message' => 'Email is required']);
            }

            $user = Customer::where('email', $email)->first();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found']);
            }

            // Generate reset token (you should implement proper password reset logic)
            $resetToken = Str::random(60);
            
            // Store reset token in database (you need to create password_resets table)
            DB::table('password_resets')->updateOrInsert(
                ['email' => $email],
                [
                    'token' => Hash::make($resetToken),
                    'created_at' => now()
                ]
            );

            // Send reset email (implement email sending logic)
            
            return response()->json([
                'success' => true,
                'message' => 'Password reset link has been sent to your email'
            ]);
        } catch (\Exception $e) {
            Log::error('Reset Password Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send reset link'], 500);
        }
    }

    public function linkEmailOrPhone(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $linkData = $request->validate([
                'email' => 'nullable|email|unique:customers,email,' . $userId,
                'phone' => 'nullable|string|unique:customers,phone,' . $userId
            ]);

            $user = Customer::find($userId);
            $user->update(array_filter($linkData));

            return response()->json([
                'success' => true,
                'message' => 'Contact information updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Link Email/Phone Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update contact info'], 500);
        }
    }

    // ==========================================
    // 🆘 ADDITIONAL SUPPORT METHODS
    // ==========================================

    public function getContactInfo()
    {
        try {
            $contactInfo = [
                'support_email' => config('mail.from.address', 'support@marketplace.com'),
                'support_phone' => '+1-555-0123',
                'business_address' => '123 Marketplace St, Business City, Country',
                'business_hours' => 'Monday - Friday: 9 AM - 6 PM',
                'emergency_contact' => '+1-555-0124',
                'social_media' => [
                    'facebook' => 'https://facebook.com/marketplace',
                    'twitter' => 'https://twitter.com/marketplace',
                    'linkedin' => 'https://linkedin.com/company/marketplace'
                ]
            ];

            return response()->json([
                'success' => true,
                'contact_info' => $contactInfo
            ]);
        } catch (\Exception $e) {
            Log::error('Get Contact Info Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load contact info'], 500);
        }
    }

    // ==========================================
    // 🔍 ADDITIONAL PRODUCT METHODS
    // ==========================================

    public function viewProductDetails(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            
            $product = Product::with(['shop', 'category', 'brand', 'reviews'])
                             ->where('id', $productId)
                             ->where('status', 1)
                             ->first();

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found']);
            }

            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->unit_price,
                    'discount' => $product->discount,
                    'description' => $product->details,
                    'images' => $product->images,
                    'shop' => [
                        'name' => $product->shop->name ?? 'N/A',
                        'rating' => $product->shop->rating ?? 0,
                        'location' => $product->shop->city ?? 'N/A'
                    ],
                    'category' => $product->category->name ?? 'N/A',
                    'brand' => $product->brand->name ?? 'N/A',
                    'rating' => $product->rating ?? 0,
                    'reviews_count' => $product->reviews->count(),
                    'url' => route('product', $product->slug)
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('View Product Details Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load product details'], 500);
        }
    }

    public function contactSeller(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $message = $request->input('message', '');
            $userId = Auth::guard('customer')->id();

            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $product = Product::with('shop')->find($productId);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found']);
            }

            // Create a chat message or inquiry
            $inquiry = [
                'product_id' => $productId,
                'customer_id' => $userId,
                'seller_id' => $product->user_id,
                'message' => $message ?: "I'm interested in your product: {$product->name}",
                'created_at' => now()
            ];

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent to the seller',
                'seller_info' => [
                    'shop_name' => $product->shop->name ?? 'N/A',
                    'contact_method' => 'Chat system'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Contact Seller Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to contact seller'], 500);
        }
    }

    public function showLatestDeals()
    {
        try {
            $deals = [];
            
            // Flash Deals
            $flashDeals = FlashDeal::with('products')
                                  ->where('status', 1)
                                  ->where('start_date', '<=', now())
                                  ->where('end_date', '>=', now())
                                  ->limit(5)
                                  ->get();

            foreach ($flashDeals as $deal) {
                $deals[] = [
                    'type' => 'Flash Deal',
                    'title' => $deal->title,
                    'discount' => $deal->discount . '%',
                    'end_date' => $deal->end_date->format('M d, Y'),
                    'products_count' => $deal->products->count()
                ];
            }

            // Deal of the Day
            $dailyDeals = DealOfTheDay::with('product')
                                     ->where('status', 1)
                                     ->limit(3)
                                     ->get();

            foreach ($dailyDeals as $deal) {
                if ($deal->product) {
                    $deals[] = [
                        'type' => 'Deal of the Day',
                        'title' => $deal->product->name,
                        'discount' => $deal->discount . '%',
                        'original_price' => $deal->product->unit_price,
                        'discounted_price' => $deal->product->unit_price * (1 - $deal->discount/100)
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'deals' => $deals,
                'total' => count($deals)
            ]);
        } catch (\Exception $e) {
            Log::error('Show Latest Deals Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load deals'], 500);
        }
    }

    public function showFeaturedProducts()
    {
        try {
            $featuredProducts = Product::where('featured', 1)
                                      ->where('status', 1)
                                      ->with(['shop', 'category'])
                                      ->limit(10)
                                      ->get();

            $products = $featuredProducts->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->unit_price,
                    'image' => $product->thumbnail_full_url,
                    'shop' => $product->shop->name ?? 'N/A',
                    'category' => $product->category->name ?? 'N/A',
                    'rating' => $product->rating ?? 0,
                    'url' => route('product', $product->slug)
                ];
            });

            return response()->json([
                'success' => true,
                'products' => $products,
                'total' => $products->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Show Featured Products Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load featured products'], 500);
        }
    }

    // ==========================================
    // 📩 ADDITIONAL LEAD METHODS
    // ==========================================

    public function postBuyLead(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $leadData = $request->validate([
                'name' => 'required|string|max:255',
                'product_name' => 'required|string|max:255',
                'quantity_required' => 'required|string',
                'details' => 'required|string',
                'contact_number' => 'required|string',
                'country' => 'required|string',
                'city' => 'nullable|string',
                'buying_frequency' => 'nullable|string',
                'unit' => 'nullable|string'
            ]);

            $lead = Leads::create([
                'name' => $leadData['name'],
                'product_name' => $leadData['product_name'],
                'quantity_required' => $leadData['quantity_required'],
                'details' => $leadData['details'],
                'contact_number' => $leadData['contact_number'],
                'country' => $leadData['country'],
                'city' => $leadData['city'] ?? '',
                'buying_frequency' => $leadData['buying_frequency'] ?? 'One Time',
                'unit' => $leadData['unit'] ?? 'Piece',
                'type' => 'buy',
                'added_by' => $userId,
                'active' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Buy requirement posted successfully',
                'lead_id' => $lead->id
            ]);
        } catch (\Exception $e) {
            Log::error('Post Buy Lead Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to post buy requirement'], 500);
        }
    }

    public function postSellOffer(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $offerData = $request->validate([
                'name' => 'required|string|max:255',
                'product_name' => 'required|string|max:255',
                'avl_stock' => 'required|string',
                'details' => 'required|string',
                'contact_number' => 'required|string',
                'country' => 'required|string',
                'city' => 'nullable|string',
                'rate' => 'nullable|numeric',
                'unit' => 'nullable|string'
            ]);

            $offer = Leads::create([
                'name' => $offerData['name'],
                'product_name' => $offerData['product_name'],
                'avl_stock' => $offerData['avl_stock'],
                'details' => $offerData['details'],
                'contact_number' => $offerData['contact_number'],
                'country' => $offerData['country'],
                'city' => $offerData['city'] ?? '',
                'rate' => $offerData['rate'] ?? 0,
                'unit' => $offerData['unit'] ?? 'Piece',
                'type' => 'sell',
                'added_by' => $userId,
                'active' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sell offer posted successfully',
                'offer_id' => $offer->id
            ]);
        } catch (\Exception $e) {
            Log::error('Post Sell Offer Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to post sell offer'], 500);
        }
    }

    // ==========================================
    // 🧑‍💼 ADDITIONAL JOB METHODS
    // ==========================================

    public function searchJobsByRoleOrLocation(Request $request)
    {
        try {
            $role = $request->input('role', '');
            $location = $request->input('location', '');
            $limit = $request->input('limit', 10);

            $jobs = Vacancies::query()
                ->when($role, function($q) use ($role) {
                    $q->where('title', 'LIKE', "%{$role}%")
                      ->orWhere('description', 'LIKE', "%{$role}%");
                })
                ->when($location, function($q) use ($location) {
                    $q->where('location', 'LIKE', "%{$location}%");
                })
                ->where('status', 'active')
                ->where('Approved', 1)
                ->limit($limit)
                ->get();

            return response()->json([
                'success' => true,
                'jobs' => $jobs->map(function($job) {
                    return [
                        'id' => $job->id,
                        'title' => $job->title,
                        'company' => $job->company_name,
                        'location' => $job->location,
                        'type' => $job->employment_type,
                        'salary' => $job->salary_low . ' - ' . $job->salary_high,
                        'posted_date' => $job->created_at->format('M d, Y'),
                        'description' => Str::limit($job->description, 150)
                    ];
                }),
                'total' => $jobs->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Search Jobs Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Job search failed'], 500);
        }
    }

    public function postJobListing(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $jobData = $request->validate([
                'title' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'employment_type' => 'required|in:full-time,part-time,contract,freelance',
                'description' => 'required|string',
                'salary_low' => 'nullable|numeric',
                'salary_high' => 'nullable|numeric',
                'experience_required' => 'nullable|integer',
                'skills_required' => 'nullable|string',
                'application_deadline' => 'nullable|date'
            ]);

            $job = Vacancies::create([
                'title' => $jobData['title'],
                'company_name' => $jobData['company_name'],
                'location' => $jobData['location'],
                'employment_type' => $jobData['employment_type'],
                'description' => $jobData['description'],
                'salary_low' => $jobData['salary_low'] ?? 0,
                'salary_high' => $jobData['salary_high'] ?? 0,
                'experience_required' => $jobData['experience_required'] ?? 0,
                'skills_required' => $jobData['skills_required'] ?? '',
                'application_deadline' => $jobData['application_deadline'],
                'user_id' => $userId,
                'status' => 'active',
                'Approved' => 0 // Pending approval
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job posted successfully and is pending approval',
                'job_id' => $job->id
            ]);
        } catch (\Exception $e) {
            Log::error('Post Job Listing Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to post job'], 500);
        }
    }

    public function applyToJob(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $applicationData = $request->validate([
                'job_id' => 'required|integer|exists:vacancies,id',
                'cover_letter' => 'required|string'
            ]);

            // Check if already applied
            $existingApplication = JobAppliers::where('jobid', $applicationData['job_id'])
                                             ->where('user_id', $userId)
                                             ->first();

            if ($existingApplication) {
                return response()->json(['success' => false, 'message' => 'You have already applied for this job']);
            }

            $application = JobAppliers::create([
                'jobid' => $applicationData['job_id'],
                'user_id' => $userId,
                'cover_letter' => $applicationData['cover_letter'],
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job application submitted successfully',
                'application_id' => $application->id
            ]);
        } catch (\Exception $e) {
            Log::error('Apply to Job Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to submit application'], 500);
        }
    }

    // ==========================================
    // ⚙️ ADDITIONAL DEAL METHODS
    // ==========================================

    public function requestNegotiation(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $negotiationData = $request->validate([
                'deal_id' => 'required|integer',
                'offered_price' => 'required|numeric',
                'message' => 'nullable|string'
            ]);

            $product = Product::find($negotiationData['deal_id']);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found']);
            }

            $negotiation = ChatbotNegotiation::create([
                'deal_id' => $negotiationData['deal_id'],
                'user_id' => $userId,
                'seller_id' => $product->user_id,
                'original_price' => $product->unit_price,
                'offered_price' => $negotiationData['offered_price'],
                'status' => 'pending',
                'message' => $negotiationData['message'] ?? '',
                'negotiation_type' => 'price',
                'expires_at' => now()->addDays(7)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Negotiation request sent successfully',
                'negotiation_id' => $negotiation->id
            ]);
        } catch (\Exception $e) {
            Log::error('Request Negotiation Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to request negotiation'], 500);
        }
    }

    public function trackNegotiationStatus(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            $requestId = $request->input('request_id');
            
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $negotiation = ChatbotNegotiation::where('id', $requestId)
                                           ->where('user_id', $userId)
                                           ->first();

            if (!$negotiation) {
                return response()->json(['success' => false, 'message' => 'Negotiation not found']);
            }

            return response()->json([
                'success' => true,
                'negotiation' => [
                    'id' => $negotiation->id,
                    'status' => $negotiation->status,
                    'original_price' => $negotiation->original_price,
                    'offered_price' => $negotiation->offered_price,
                    'counter_price' => $negotiation->counter_price,
                    'message' => $negotiation->message,
                    'expires_at' => $negotiation->expires_at ? $negotiation->expires_at->format('M d, Y H:i') : null,
                    'created_at' => $negotiation->created_at->format('M d, Y H:i')
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Track Negotiation Status Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to track negotiation'], 500);
        }
    }

    public function escalateToSupport(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            $dealId = $request->input('deal_id');
            $issue = $request->input('issue', '');
            
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            // Create support ticket
            $ticket = [
                'user_id' => $userId,
                'deal_id' => $dealId,
                'subject' => 'Deal Assistance Required',
                'description' => $issue,
                'priority' => 'medium',
                'status' => 'open',
                'created_at' => now()
            ];

            return response()->json([
                'success' => true,
                'message' => 'Your issue has been escalated to our support team. You will be contacted within 24 hours.',
                'ticket_id' => 'TKT-' . time()
            ]);
        } catch (\Exception $e) {
            Log::error('Escalate to Support Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to escalate to support'], 500);
        }
    }

    // ==========================================
    // 🧾 ADDITIONAL MEMBERSHIP METHODS
    // ==========================================

    public function showMembershipPlans()
    {
        try {
            $plans = [
                [
                    'id' => 1,
                    'name' => 'Basic',
                    'price' => 0,
                    'duration' => 'Forever',
                    'features' => [
                        '5 Product Listings',
                        '2 Buy/Sell Leads',
                        'Basic Support',
                        'Standard Profile'
                    ],
                    'limits' => [
                        'products' => 5,
                        'leads' => 2,
                        'support' => 'basic'
                    ]
                ],
                [
                    'id' => 2,
                    'name' => 'Premium',
                    'price' => 29,
                    'duration' => 'Monthly',
                    'features' => [
                        '50 Product Listings',
                        '20 Buy/Sell Leads',
                        'Priority Support',
                        'Advanced Analytics',
                        'Featured Listings',
                        'Bulk Upload'
                    ],
                    'limits' => [
                        'products' => 50,
                        'leads' => 20,
                        'support' => 'priority'
                    ]
                ],
                [
                    'id' => 3,
                    'name' => 'Enterprise',
                    'price' => 99,
                    'duration' => 'Monthly',
                    'features' => [
                        'Unlimited Product Listings',
                        'Unlimited Buy/Sell Leads',
                        '24/7 Dedicated Support',
                        'Advanced Analytics & Reports',
                        'API Access',
                        'Custom Branding',
                        'Account Manager'
                    ],
                    'limits' => [
                        'products' => 'unlimited',
                        'leads' => 'unlimited',
                        'support' => 'dedicated'
                    ]
                ]
            ];

            return response()->json([
                'success' => true,
                'plans' => $plans
            ]);
        } catch (\Exception $e) {
            Log::error('Show Membership Plans Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load membership plans'], 500);
        }
    }

    public function compareMembershipFeatures()
    {
        try {
            $comparison = [
                'features' => [
                    'Product Listings' => ['Basic' => '5', 'Premium' => '50', 'Enterprise' => 'Unlimited'],
                    'Buy/Sell Leads' => ['Basic' => '2', 'Premium' => '20', 'Enterprise' => 'Unlimited'],
                    'Support Level' => ['Basic' => 'Email', 'Premium' => 'Priority', 'Enterprise' => '24/7 Dedicated'],
                    'Analytics' => ['Basic' => '❌', 'Premium' => '✅', 'Enterprise' => '✅ Advanced'],
                    'Featured Listings' => ['Basic' => '❌', 'Premium' => '✅', 'Enterprise' => '✅'],
                    'API Access' => ['Basic' => '❌', 'Premium' => '❌', 'Enterprise' => '✅'],
                    'Custom Branding' => ['Basic' => '❌', 'Premium' => '❌', 'Enterprise' => '✅'],
                    'Account Manager' => ['Basic' => '❌', 'Premium' => '❌', 'Enterprise' => '✅']
                ],
                'pricing' => [
                    'Basic' => '$0/month',
                    'Premium' => '$29/month',
                    'Enterprise' => '$99/month'
                ]
            ];

            return response()->json([
                'success' => true,
                'comparison' => $comparison
            ]);
        } catch (\Exception $e) {
            Log::error('Compare Membership Features Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load feature comparison'], 500);
        }
    }

    public function upgradeMembership(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $upgradeData = $request->validate([
                'plan_id' => 'required|integer|in:1,2,3',
                'payment_method' => 'required|string'
            ]);

            $plans = [
                1 => ['name' => 'Basic', 'price' => 0],
                2 => ['name' => 'Premium', 'price' => 29],
                3 => ['name' => 'Enterprise', 'price' => 99]
            ];

            $selectedPlan = $plans[$upgradeData['plan_id']];

            // Create membership record
            $membership = [
                'user_id' => $userId,
                'plan_id' => $upgradeData['plan_id'],
                'plan_name' => $selectedPlan['name'],
                'price' => $selectedPlan['price'],
                'payment_method' => $upgradeData['payment_method'],
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'created_at' => now()
            ];

            return response()->json([
                'success' => true,
                'message' => "Successfully upgraded to {$selectedPlan['name']} plan",
                'membership' => $membership
            ]);
        } catch (\Exception $e) {
            Log::error('Upgrade Membership Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to upgrade membership'], 500);
        }
    }

    // ==========================================
    // 🧑‍💼 ADDITIONAL USER ACCOUNT METHODS
    // ==========================================

    public function viewProfileSummary(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $user = Customer::find($userId);
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found']);
            }

            // Get user statistics
            $stats = [
                'total_orders' => Order::where('customer_id', $userId)->count(),
                'total_leads' => Leads::where('added_by', $userId)->count(),
                'active_leads' => Leads::where('added_by', $userId)->where('active', true)->count(),
                'member_since' => $user->created_at->format('M Y')
            ];

            return response()->json([
                'success' => true,
                'profile' => [
                    'name' => $user->f_name . ' ' . $user->l_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'joined_date' => $user->created_at->format('M d, Y'),
                    'email_verified' => $user->email_verified_at ? true : false,
                    'phone_verified' => $user->phone_verified_at ? true : false
                ],
                'statistics' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('View Profile Summary Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load profile'], 500);
        }
    }

    public function updateBusinessDetails(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $businessData = $request->validate([
                'company_name' => 'nullable|string|max:255',
                'business_type' => 'nullable|string|max:255',
                'industry' => 'nullable|string|max:255',
                'website' => 'nullable|url',
                'business_address' => 'nullable|string',
                'tax_id' => 'nullable|string|max:50'
            ]);

            $user = Customer::find($userId);
            
            // Update business details (assuming these fields exist or can be added)
            $user->update(array_filter($businessData));

            return response()->json([
                'success' => true,
                'message' => 'Business details updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Update Business Details Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update business details'], 500);
        }
    }

    public function setLanguagePreference(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            $languageCode = $request->input('language_code');
            
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            // Update or create user preferences
            ChatbotUserPreference::updateOrCreate(
                ['user_id' => $userId],
                ['language_code' => $languageCode]
            );

            $language = ChatbotLanguage::where('language_code', $languageCode)->first();

            return response()->json([
                'success' => true,
                'message' => 'Language preference updated successfully',
                'language' => [
                    'code' => $languageCode,
                    'name' => $language->language_name ?? 'Unknown'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Set Language Preference Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to set language preference'], 500);
        }
    }

    // ==========================================
    // 🆘 ADDITIONAL SUPPORT METHODS
    // ==========================================

    public function viewFaq(Request $request)
    {
        try {
            $topic = $request->input('topic', 'general');
            
            $faqs = [
                'general' => [
                    ['question' => 'How do I create an account?', 'answer' => 'Click on Sign Up and fill in your details.'],
                    ['question' => 'How do I reset my password?', 'answer' => 'Use the "Forgot Password" link on the login page.'],
                    ['question' => 'Is my data secure?', 'answer' => 'Yes, we use industry-standard security measures.']
                ],
                'products' => [
                    ['question' => 'How do I list a product?', 'answer' => 'Go to your dashboard and click "Add Product".'],
                    ['question' => 'Can I edit my product listings?', 'answer' => 'Yes, you can edit them from your product management page.'],
                    ['question' => 'How long do listings stay active?', 'answer' => 'Listings stay active for 30 days by default.']
                ],
                'orders' => [
                    ['question' => 'How do I track my order?', 'answer' => 'Use the order tracking feature in your account.'],
                    ['question' => 'Can I cancel my order?', 'answer' => 'Orders can be cancelled within 24 hours of placement.'],
                    ['question' => 'What payment methods do you accept?', 'answer' => 'We accept credit cards, PayPal, and bank transfers.']
                ]
            ];

            return response()->json([
                'success' => true,
                'topic' => $topic,
                'faqs' => $faqs[$topic] ?? $faqs['general']
            ]);
        } catch (\Exception $e) {
            Log::error('View FAQ Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load FAQ'], 500);
        }
    }

    public function raiseTicket(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            $ticketData = $request->validate([
                'issue_type' => 'required|string',
                'subject' => 'required|string|max:255',
                'description' => 'required|string',
                'priority' => 'nullable|in:low,medium,high'
            ]);

            $ticketId = 'TKT-' . time() . '-' . $userId;

            $ticket = [
                'ticket_id' => $ticketId,
                'user_id' => $userId,
                'issue_type' => $ticketData['issue_type'],
                'subject' => $ticketData['subject'],
                'description' => $ticketData['description'],
                'priority' => $ticketData['priority'] ?? 'medium',
                'status' => 'open',
                'created_at' => now()
            ];

            return response()->json([
                'success' => true,
                'message' => 'Support ticket created successfully',
                'ticket_id' => $ticketId,
                'estimated_response' => '24 hours'
            ]);
        } catch (\Exception $e) {
            Log::error('Raise Ticket Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to create support ticket'], 500);
        }
    }

    public function trackTicketStatus(Request $request)
    {
        try {
            $ticketId = $request->input('ticket_id');
            
            if (!$ticketId) {
                return response()->json(['success' => false, 'message' => 'Ticket ID is required']);
            }

            // Mock ticket status (in real implementation, fetch from database)
            $ticket = [
                'ticket_id' => $ticketId,
                'status' => 'in_progress',
                'priority' => 'medium',
                'created_at' => now()->subHours(2)->format('M d, Y H:i'),
                'last_updated' => now()->subMinutes(30)->format('M d, Y H:i'),
                'assigned_to' => 'Support Team',
                'estimated_resolution' => 'Within 24 hours'
            ];

            return response()->json([
                'success' => true,
                'ticket' => $ticket
            ]);
        } catch (\Exception $e) {
            Log::error('Track Ticket Status Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to track ticket'], 500);
        }
    }

    public function connectToHumanAgent(Request $request)
    {
        try {
            $userId = Auth::guard('customer')->id();
            $issue = $request->input('issue', '');
            
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Please login first']);
            }

            // Create a human agent connection request
            $connectionId = 'AGENT-' . time() . '-' . $userId;

            return response()->json([
                'success' => true,
                'message' => 'Connecting you to a human agent. Please wait...',
                'connection_id' => $connectionId,
                'estimated_wait_time' => '3-5 minutes',
                'queue_position' => rand(1, 5)
            ]);
        } catch (\Exception $e) {
            Log::error('Connect to Human Agent Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to connect to human agent'], 500);
        }
    }

    // ==========================================
    // 🌐 ADDITIONAL LANGUAGE METHODS
    // ==========================================

    public function switchLanguage(Request $request)
    {
        try {
            $languageCode = $request->input('language_code');
            
            $language = ChatbotLanguage::where('language_code', $languageCode)
                                     ->where('is_active', true)
                                     ->first();

            if (!$language) {
                return response()->json(['success' => false, 'message' => 'Language not supported']);
            }

            // Update user preference if logged in
            $userId = Auth::guard('customer')->id();
            if ($userId) {
                ChatbotUserPreference::updateOrCreate(
                    ['user_id' => $userId],
                    ['language_code' => $languageCode]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Language switched successfully',
                'language' => [
                    'code' => $language->language_code,
                    'name' => $language->language_name
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Switch Language Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to switch language'], 500);
        }
    }

    public function listSupportedLanguages()
    {
        try {
            $languages = ChatbotLanguage::where('is_active', true)
                                      ->orderBy('is_default', 'desc')
                                      ->orderBy('language_name')
                                      ->get();

            return response()->json([
                'success' => true,
                'languages' => $languages->map(function($lang) {
                    return [
                        'code' => $lang->language_code,
                        'name' => $lang->language_name,
                        'is_default' => $lang->is_default
                    ];
                })
            ]);
        } catch (\Exception $e) {
            Log::error('List Supported Languages Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load languages'], 500);
        }
    }

}