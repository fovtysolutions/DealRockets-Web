<div class="vender-about-us">
    <div class="company-section">
        <aside class="company-sidebar">
            <ul>
                <li class="sidebar-tab active" data-tab="overview">Company Overview</li>
                <li class="sidebar-tab" data-tab="production">Production Capacity</li>
                <li class="sidebar-tab" data-tab="quality">Quality Control</li>
                <li class="sidebar-tab" data-tab="rnd">R&D Capabilities</li>
            </ul>
        </aside>

        <main class="company-content">
            {{-- Company Overview --}}
            <div class="sidebar-content tab-overview">
                <div class="company-header">
                    <div class="company-intro">
                        <h3>{{ $shopInfoArray['company_profiles']->title ?? 'N/A' }}</h3>
                        <p class="company-meta">{{ $shopInfoArray['company_profiles']->subtitle ?? 'N/A' }}</p>
                        <small>Avg Response time: <strong>48–72 h</strong></small>
                        <div class="mt-4">
                            <h3>{{ $shopInfoArray['company_profiles']->description_head ?? '' }}</h3>
                            <p>{{ $shopInfoArray['company_profiles']->description_text ?? '' }}</p>
                        </div>
                    </div>
                    <div class="company-image">
                        @if (!empty($shopInfoArray['images'][0]))
                            <img src="/storage/{{ $shopInfoArray['images'][0] }}" alt="Company Interior"  onerror="this.onerror=null; this.src='/images/placeholderimage.webp';" />
                        @endif
                    </div>
                </div>

                {{-- Basic Information --}}
                <section class="info-table">
                    <h5>Basic Information</h5>
                    <table>
                        <tr>
                            <td>Total Capitalization</td>
                            <td colspan="3">
                                US${{ $shopInfoArray['company_profiles']->total_capitalization ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Year Established</td>
                            <td>{{ $shopInfoArray['company_profiles']->year_established ?? 'N/A' }}</td>
                            <td>Total Employees</td>
                            <td>{{ $shopInfoArray['company_profiles']->total_employees ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Company Certificate</td>
                            <td>{{ $shopInfoArray['company_profiles']->company_certificates ?? 'N/A' }}</td>
                            <td>Product Certificate</td>
                            <td>{{ $shopInfoArray['company_profiles']->product_certificates ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Business Type</td>
                            <td colspan="3">{{ $shopInfoArray['company_profiles']->business_type ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </section>

                {{-- Trading Capabilities --}}
                <section class="info-table">
                    <h5>Trading Capabilities</h5>
                    <table>
                        <tr>
                            <td>Total Annual Sales</td>
                            <td>{{ $shopInfoArray['company_profiles']->total_annual_sales ?? 'N/A' }}</td>
                            <td>Export Percentage</td>
                            <td>{{ $shopInfoArray['company_profiles']->export_percentage ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>OEM Service</td>
                            <td>{{ ($shopInfoArray['company_profiles']->oem_service ?? 0) == 1 ? 'Yes' : 'No' }}</td>
                            <td>Small Orders Accepted</td>
                            <td>{{ ($shopInfoArray['company_profiles']->small_orders_accepted ?? 0) == 1 ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                    </table>
                </section>
            </div>

            {{-- Production Capacity --}}
            <div class="sidebar-content tab-production d-none">
                <section class="info-table">
                    <h5>Production Capacity</h5>
                    <table>
                        <tr>
                            <td>Factory Size</td>
                            <td>{{ $shopInfoArray['company_profiles']->factory_size ?? 'N/A' }}</td>
                            <td>Production Lines</td>
                            <td>{{ $shopInfoArray['company_profiles']->production_lines ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Monthly Output</td>
                            <td>{{ $shopInfoArray['company_profiles']->monthly_output ?? 'N/A' }}</td>
                            <td>Lead Time</td>
                            <td>{{ $shopInfoArray['company_profiles']->lead_time ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Main Products</td>
                            <td>{{ $shopInfoArray['company_profiles']->main_products ?? 'N/A' }}</td>
                            <td>Product Categories</td>
                            <td>{{ $shopInfoArray['company_profiles']->product_categories ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Main Export Markets</td>
                            <td>{{ $shopInfoArray['company_profiles']->main_export_markets ?? 'N/A' }}</td>
                            <td>Hot Products</td>
                            <td>{{ $shopInfoArray['company_profiles']->hot_products ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Payment Terms</td>
                            <td>{{ $shopInfoArray['company_profiles']->payment_terms ?? 'N/A' }}</td>
                            <td>Delivery Terms</td>
                            <td>{{ $shopInfoArray['company_profiles']->delivery_terms ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </section>
            </div>

            {{-- Quality Control --}}
            <div class="sidebar-content tab-quality d-none">
                <section class="info-table">
                    <h5>Quality Control</h5>
                    <table>
                        <tr>
                            <td>QC Staff Count</td>
                            <td>{{ $shopInfoArray['company_profiles']->qc_staff_count ?? 'N/A' }}</td>
                            <td>Inspection Process</td>
                            <td>{{ $shopInfoArray['company_profiles']->inspection_process ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Testing Equipment</td>
                            <td>{{ $shopInfoArray['company_profiles']->testing_equipment ?? 'N/A' }}</td>
                            <td>QC Certifications</td>
                            <td>{{ $shopInfoArray['company_profiles']->qc_certifications ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </section>
            </div>

            {{-- R&D Capabilities --}}
            <div class="sidebar-content tab-rnd d-none">
                <section class="info-table">
                    <h5>R&D Capabilities</h5>
                    <table>
                        <tr>
                            <td>R&D Staff Count</td>
                            <td>{{ $shopInfoArray['company_profiles']->rd_staff_count ?? 'N/A' }}</td>
                            <td>Patents</td>
                            <td>{{ $shopInfoArray['company_profiles']->patents ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Annual R&D Spending</td>
                            <td>{{ $shopInfoArray['company_profiles']->annual_rd_spending ?? 'N/A' }}</td>
                            <td>Customization Offered</td>
                            <td>{{ ($shopInfoArray['company_profiles']->customization_offered ?? 0) == 1 ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Product Development Time</td>
                            <td colspan="3">{{ $shopInfoArray['company_profiles']->product_dev_time ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </section>
            </div>
        </main>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.sidebar-tab');
        const contents = document.querySelectorAll('.sidebar-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active from all tabs
                tabs.forEach(t => t.classList.remove('active'));
                // Hide all contents using d-none
                contents.forEach(c => c.classList.add('d-none'));
                // Activate this tab
                this.classList.add('active');
                // Show the corresponding content by removing d-none
                document.querySelector('.tab-' + this.dataset.tab).classList.remove('d-none');
            });
        });
    });
</script>
