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
            <div class="sidebar-content tab-overview">
                <div class="company-header">
                    <div class="company-intro">
                        <h3>{{ $shopInfoArray['company_profiles']->title }}</h3>
                        <p class="company-meta">{{ $shopInfoArray['company_profiles']->subtitle }}</p>
                        <small>Avg Response time: <strong>48–72 h</strong></small>
                        <div class="mt-4">
                            <h3>{{ $shopInfoArray['company_profiles']->description_head }}</h3>
                            <p>{{ $shopInfoArray['company_profiles']->description_text }}</p>
                        </div>


                    </div>
                    <div class="company-image">
                        <img src="/storage/{{ $shopInfoArray['images'][0] }}" alt="Company Interior" />
                    </div>
                </div>
                <section class="info-table">
                    <h5>Basic Information</h5>
                    <table>
                        <tr>
                            <td>Total Capitalization</td>
                            <td colspan="3">US${{ $shopInfoArray['company_profiles']->total_capitalization }}</td>
                        </tr>
                        <tr>
                            <td>Year Established</td>
                            <td>{{ $shopInfoArray['company_profiles']->year_established }}</td>
                            <td>Total Employees</td>
                            <td>{{ $shopInfoArray['company_profiles']->total_employees }}</td>
                        </tr>
                        <tr>
                            <td> Company Certificate</td>
                            <td>{{ $shopInfoArray['company_profiles']->company_certificates }}</td>
                            <td>Product Certificate</td>
                            <td>{{ $shopInfoArray['company_profiles']->product_certificates }}</td>
                        </tr>
                        <tr>
                            <td>Business Type</td>
                            <td colspan="3">{{ $shopInfoArray['company_profiles']->business_type }}
                            </td>

                        </tr>
                    </table>
                </section>
                <section class="info-table">
                    <h5>Trading Capabilities</h5>
                    <table>
                        <tr>
                            <td>Total Annual Sales</td>
                            <td>{{ $shopInfoArray['company_profiles']->total_annual_sales }}</td>
                            <td>Export Percentage</td>
                            <td>{{ $shopInfoArray['company_profiles']->export_percentage }}</td>
                        </tr>
                        <tr>
                            <td>OEM Service</td>
                            <td>{{ $shopInfoArray['company_profiles']->oem_service == 1 ? 'Yes' : 'No' }}</td>
                            <td>Small Orders Accepted</td>
                            <td>{{ $shopInfoArray['company_profiles']->small_orders_accepted == 1 ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                    </table>
                </section>
            </div>
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
                            <td>
                                @if (!empty($shopInfoArray['company_profiles']->main_products))
                                    {{ $shopInfoArray['company_profiles']->main_products }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>Product Categories</td>
                            <td>
                                @if (!empty($shopInfoArray['company_profiles']->product_categories))
                                    {{ $shopInfoArray['company_profiles']->product_categories }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Main Export Markets</td>
                            <td>
                                @if (!empty($shopInfoArray['company_profiles']->main_export_markets))
                                    {{ $shopInfoArray['company_profiles']->main_export_markets }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>Hot Products</td>
                            <td>
                                @if (!empty($shopInfoArray['company_profiles']->hot_products))
                                    {{ $shopInfoArray['company_profiles']->hot_products }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Payment Terms</td>
                            <td>
                                @if (!empty($shopInfoArray['company_profiles']->payment_terms))
                                    {{ $shopInfoArray['company_profiles']->payment_terms }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>Delivery Terms</td>
                            <td>
                                @if (!empty($shopInfoArray['company_profiles']->delivery_terms))
                                    {{ $shopInfoArray['company_profiles']->delivery_terms }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </table>
                </section>
            </div>
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
                            <td>
                                @if (!empty($shopInfoArray['company_profiles']->testing_equipment))
                                    {{ $shopInfoArray['company_profiles']->testing_equipment }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>QC Certifications</td>
                            <td>
                                @if (!empty($shopInfoArray['company_profiles']->qc_certifications))
                                    {{ $shopInfoArray['company_profiles']->qc_certifications }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </table>
                </section>
            </div>
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
                            <td>{{ $shopInfoArray['company_profiles']->customization_offered == 1 ? 'Yes' : 'No' }}
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
