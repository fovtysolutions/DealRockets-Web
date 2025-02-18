@extends('layouts.back-end.app')

@section('title', translate('Website Setting'))

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .customertiers span {
            font-size: smaller;
        }

        .sellertiers span {
            font-size: smaller;
        }

        .randomclass span {
            font-size: medium;
            margin-left: 10px;
        }

        .randomclass input[type=checkbox] {
            height: 0;
            width: 0;
            visibility: hidden;
        }

        .randomclass label {
            cursor: pointer;
            text-indent: -9999px;
            width: 50px;
            height: 25px;
            background: grey;
            display: block;
            border-radius: 100px;
            position: relative;
        }

        .randomclass label:after {
            content: '';
            position: absolute;
            top: 3px;
            left: 5px;
            width: 19px;
            height: 19px;
            background: #fff;
            border-radius: 90px;
            transition: 0.3s;
        }

        .randomclass input:checked+label {
            background: #bada55;
        }

        .randomclass input:checked+label:after {
            left: calc(100% - 5px);
            transform: translateX(-100%);
        }

        .randomclass label:active:after {
            width: 19px;
        }

        .randomclass1 .mainDiv {
            width: 100%;
            height: 15vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .randomclass1 .mainSwitch {
            height: 50px;
            width: 200px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-around;
            background-color: lightgray;
            border-radius: 50px;
        }

        .randomclass1 .mainSwitch button {
            background-color: transparent;
            border: none;
            z-index: 10;
        }

        .randomclass1 .backgroundPill {
            position: absolute;
            background-color: white;
            width: 100px;
            height: 40px;
            border-radius: 50px;
            left: 5px;
            transition: 0.5s;
            box-shadow: 0 8px 8px 0 rgba(0, 0, 0, 0.1)
        }

        /* Make the table headers and cells larger */
        table {
            width: 100%;
            font-size: 16px;
            /* Increase font size for better readability */
        }

        /* Style the table headers */
        th {
            font-weight: bold;
            padding: 10px;
            font-size: 14px;
            /* Increase padding to make it more spacious */
            text-align: left;
        }

        /* Make table cells more spacious */
        td {
            padding: 10px;
            font-size: 14px;
            /* Increase padding to make the content more comfortable */
        }

        /* Style the input fields to make them more prominent */
        input.form-control {
            font-size: 16px;
            /* Make input text larger */
            padding: 8px;
            /* Increase padding inside input fields */
        }

        /* Adjust button size for better visibility */
        button {
            font-size: 16px;
            padding: 8px 12px;
        }
    </style>
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/system-setting.png') }}" alt="">
                {{ translate('web_membership_Setting') }}
            </h2>
        </div>
        @include('admin-views.business-settings.theme-pages.theme-pages-selector')

        <div class="row randomclass1">
            <div class="mainDiv">
                <div class="mainSwitch">
                    <div class="backgroundPill"></div>
                    <button onclick="movePill(this)" value="customer">Customer</button>
                    <button onclick="movePill(this)" value="seller">Seller</button>
                </div>
            </div>
        </div>

        <!-- Customer Tier Section -->
        <div class="row customertiers" id="customerTiers" style="display: block;">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.webtheme.memsetting') }}" id="dynamicFormCustomer">
                        @csrf
                        <input type="hidden" name="totalTiers" value="{{ $memdata['totalTiers'] ?? 1 }}">
                        <div style="overflow-x: auto;">
                            <table class="table border-0">
                                <thead>
                                    <tr>
                                        <th class="text-primary font-weight-bold text-capitalize" style="font-size:14px;">
                                            Type</th>
                                        <th class="text-primary font-weight-bold text-capitalize" style="font-size:14px;">
                                            Description</th>
                                        @for ($i = 1; $i <= ($memdata['totalTiers'] ?? 1); $i++)
                                            <th class="text-primary font-weight-bold text-capitalize"
                                                style="font-size:14px;">Feature {{ $i }}</th>
                                        @endfor
                                        <th class="text-right" style="font-size:14px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="formBodyCustomer">
                                    @if (!empty($memdata['type']))
                                        @foreach ($memdata['type'] as $index => $typeValue)
                                            <tr id="copythiscustomer">
                                                <td>
                                                    <input type="text" class="form-control" name="type[]"
                                                        value="{{ $typeValue }}" placeholder="Enter Type">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="desc[]"
                                                        value="{{ $memdata['desc'][$index] ?? '' }}" placeholder="Enter Short Description">
                                                </td>
                                                @for ($i = 1; $i <= $memdata['totalTiers']; $i++)
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="feature{{ $i }}[]"
                                                            value="{{ $memdata['feature' . $i][$index] ?? '' }}"
                                                            placeholder="Enter Feature {{ $i }}">
                                                    </td>
                                                @endfor
                                                <td class="text-right">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="removeRow(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <!-- Show one empty row if no data exists -->
                                        <tr id="copythiscustomer">
                                            <td>
                                                <input type="text" class="form-control" name="type[]"
                                                    placeholder="Enter Type">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="desc[]"
                                                    placeholder="Enter Short Description">
                                            </td>
                                            @for ($i = 1; $i <= ($memdata['totalTiers'] ?? 1); $i++)
                                                <td>
                                                    <input type="text" class="form-control"
                                                        name="feature{{ $i }}[]"
                                                        placeholder="Enter Feature {{ $i }}">
                                                </td>
                                            @endfor
                                            <td class="text-right">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="removeRow(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary mt-3 mr-2" id="addRowButtonCustomer">+ Add More
                            Rows</button>
                        <button type="submit" class="btn btn-success mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Seller Tier Section -->
        <div class="row sellertiers" id="sellerTiers" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.webtheme.memsettingseller') }}" id="dynamicFormSeller">
                        @csrf
                        <input type="hidden" name="totalTiers" value="{{ $total_seller_tiers }}">
                        <div style="overflow-x: auto;">
                            <table class="table border-0">
                                <thead>
                                    <tr>
                                        <th class="text-primary font-weight-bold text-capitalize" style="font-size:14px;">Type</th>
                                        <th class="text-primary font-weight-bold text-capitalize" style="font-size:14px;">
                                            Description</th>
                                        @for ($i = 0; $i < $total_seller_tiers; $i++)
                                            <th class="text-primary font-weight-bold text-capitalize" style="font-size:14px;">
                                                Feature {{ $i + 1 }}
                                            </th>
                                        @endfor
                                        <th class="text-right" style="font-size:14px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="formBodySeller">
                                    @if (!empty($memdataseller['type']))
                                        @foreach ($memdataseller['type'] as $index => $typeValue)
                                            <tr id="copythisseller">
                                                <td>
                                                    <input type="text" class="form-control" name="type[]" value="{{ $typeValue }}" placeholder="Enter Type">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="desc[]"
                                                        value="{{ $memdataseller['desc'][$index] ?? '' }}" placeholder="Enter Short Description">
                                                </td>
                                                @for ($i = 0; $i < $total_seller_tiers; $i++)
                                                    <td>
                                                        <input type="text" class="form-control" name="feature{{ $i + 1 }}[]" 
                                                               value="{{ $memdataseller['feature' . ($i + 1)][$index] ?? '' }}" 
                                                               placeholder="Enter Feature {{ $i + 1 }}">
                                                    </td>
                                                @endfor
                                                <td class="text-right">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <!-- Show one empty row if no data exists -->
                                        <tr id="copythisseller">
                                            <td>
                                                <input type="text" class="form-control" name="type[]" placeholder="Enter Type">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="desc[]"
                                                    placeholder="Enter Short Description">
                                            </td>
                                            @for ($i = 0; $i < $total_seller_tiers; $i++)
                                                <td>
                                                    <input type="text" class="form-control" name="feature{{ $i + 1 }}[]" placeholder="Enter Feature {{ $i + 1 }}">
                                                </td>
                                            @endfor
                                            <td class="text-right">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary mt-3 mr-2" id="addRowButtonSeller">+ Add More Rows</button>
                        <button type="submit" class="btn btn-success mt-3">Submit</button>
                    </form>                    
                </div>
            </div>
        </div>

        <script>
            function movePill(a) {
                let pill = document.querySelector(".backgroundPill"); // The moving pill
                let sellertiers = document.querySelector(".sellertiers"); // Seller tiers section
                let customertiers = document.querySelector(".customertiers"); // Customer tiers section
        
                if (a.value === "customer") {
                    // Move the pill to the left
                    pill.style.left = "5px";
        
                    // Show customer tiers and hide seller tiers
                    customertiers.style.display = "flex";
                    sellertiers.style.display = "none";
                } else if (a.value === "seller") {
                    // Move the pill to the right
                    pill.style.left = "47%";
        
                    // Show seller tiers and hide customer tiers
                    sellertiers.style.display = "flex";
                    customertiers.style.display = "none";
                }
            }
        </script>
        <script>
            document.getElementById('addRowButtonCustomer').addEventListener('click', function() {
                let row = document.querySelector('#copythiscustomer'); // Select the row template
                let clone = row.cloneNode(true); // Clone the row

                clone.removeAttribute('id'); // Remove ID to avoid duplicates

                // Clear the input fields in the cloned row
                let inputs = clone.querySelectorAll('input');
                inputs.forEach(input => {
                    input.value = ''; // Reset input values
                });

                // Append the cloned row to the tbody
                document.getElementById('formBodyCustomer').appendChild(clone);
            });

            // Add new row dynamically for Seller Tier
            document.getElementById('addRowButtonSeller').addEventListener('click', function() {
                let row = document.querySelector('#copythisseller'); // Select the row template
                let clone = row.cloneNode(true); // Clone the row

                clone.removeAttribute('id'); // Remove ID to avoid duplicates

                // Clear the input fields in the cloned row
                let inputs = clone.querySelectorAll('input');
                inputs.forEach(input => {
                    input.value = ''; // Reset input values
                });

                // Append the cloned row to the tbody
                document.getElementById('formBodySeller').appendChild(clone);
            });

            // Remove row function
            function removeRow(button) {
                let row = button.closest('tr');
                if (row) {
                    row.remove(); // Remove the entire <tr> element
                }
            }
        </script>
    @endsection
