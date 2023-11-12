@extends('layouts/layoutMaster')

{{-- @section('title', 'DataTables - Tables') --}}
<title>ACWAD</title>

@section('vendor-style')
    <style>
        /********************  Preloader Demo-7 *******************/
        .loader7 {
            width: 100px;
            height: 100px;
            margin: 50px auto;
            position: relative
        }

        .loader7 .loader-inner-1,
        .loader7 .loader-inner-2,
        .loader7 .loader-inner-3,
        .loader7 .loader-inner-4 {
            display: block;
            width: 20px;
            height: 20px;
            border-radius: 20px;
            position: absolute
        }

        .loader7 .loader-inner-1:before,
        .loader7 .loader-inner-2:before,
        .loader7 .loader-inner-3:before,
        .loader7 .loader-inner-4:before {
            content: "";
            display: block;
            width: 20px;
            height: 20px;
            border-radius: 20px;
            position: absolute;
            right: 0;
            animation-name: loading-7;
            animation-iteration-count: infinite;
            animation-direction: normal;
            animation-duration: 2s
        }

        .loader7 .loader-inner-1 {
            top: 0;
            left: 0;
            transform: rotate(70deg)
        }

        .loader7 .loader-inner-1:before {
            background: #06aed5
        }

        .loader7 .loader-inner-2 {
            top: 0;
            right: 0;
            transform: rotate(160deg)
        }

        .loader7 .loader-inner-2:before {
            background: #ec008c
        }

        .loader7 .loader-inner-3 {
            bottom: 0;
            right: 0;
            transform: rotate(-110deg)
        }

        .loader7 .loader-inner-3:before {
            background: #ffbf00
        }

        .loader7 .loader-inner-4 {
            bottom: 0;
            left: 0;
            transform: rotate(-20deg)
        }

        .loader7 .loader-inner-4:before {
            background: #079c00
        }

        @keyframes loading-7 {
            0% {
                width: 20px;
                right: 0
            }

            30% {
                width: 120px;
                right: -100px
            }

            60% {
                width: 20px;
                right: -100px
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <!-- Form Validation -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <!-- Form Validation -->
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection



@section('page-script')
    <script src="{{ asset('assets/js/cards-statistics.js') }}"></script>
    <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var showModalButton = document.getElementById('bayout');
            var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
            showModalButton.addEventListener('click', function() {
                modal.show(); // Show the modal when the button is clicked
                setTimeout(function() {
                    modal.hide(); // Hide the modal after 2 seconds
                    document.getElementById("show_content").style.display = "block";
                    document.body.scrollTop = 0;
                }, 2000);
            });
        });
    </script>
@endsection
@section('content')





    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif





    <div class="cards container" id="show_content" style="display: none;">
        <div class="row">
            <div class="col-lg-6 col-sm-12 mb-4">
                <div class="card h-100">
                    <div class="card-body pb-0 text-center">
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded-pill p-2">
                                <i class='ti ti-users ti-sm'></i>
                            </span>
                        </div>
                        <h5
                            class="card-title mb-0 py-3 mt-2 {{ $TotalTL >= 0 ? ' bg-label-info text-success' : ' bg-label-danger text-white' }}">
                            {{ $TotalTL }}
                        </h5>
                        <small>الحساب بالليره</small>
                    </div>
                    <div id="subscriberGained"></div>
                </div>
            </div>

            <!-- Quarterly Sales -->
            <div class="col-lg-6 col-sm-12 mb-4">
                <div class="card h-100">
                    <div class="card-body pb-0 text-center">
                        <div class="card-icon">
                            <span class="badge bg-label-danger rounded-pill p-2">
                                <i class='ti ti-shopping-cart ti-sm'></i>
                            </span>
                        </div>
                        <h5
                            class="card-title  mb-0 py-3 round mt-2{{ $TotalUSD >= 0 ? ' bg-label-info text-success' : ' bg-label-danger text-white' }}">
                            {{ $TotalUSD }}$</h5>
                        <small>الحساب بالدولر </small>
                    </div>
                    <div id="quarterlySales"></div>
                </div>
            </div>


        </div>
    </div>
    {{-- =========================== --}}



    <!-- Table -->
    <div class="">

        <div class="card">
            <h4 class="pt-3 ">
                <span class="text-muted fw-light mx-2">فرع /</span> عرض تفاصيل
            </h4>
            @if (@isset($data) && !@empty($data))
                <div class="table-responsive text-nowrap">
                    <table class="table">

                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">كود المشروع</th>
                                <th class="text-center">رقم الحساب</th>
                                <th class="text-center">اسم الفرع</th>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td class="text-center">{{ $data['id'] }}</td>
                                <td class="text-center">{{ $data['account_number'] }}</td>
                                <td class="text-center"> {{ $data['name'] }}</td>
                            </tr>

                        </tbody>
                        <br>
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">ايميل الفرع</th>
                                <th class="text-center">هاتف الفرع</th>
                                <th class="text-center">عنوان الفرع</th>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td class="text-center"> {{ $data['email'] }}</td>
                                <td class="text-center">{{ $data['phone'] }}</td>
                                <td class="text-center"> {{ $data['address'] }}</td>
                            </tr>

                        </tbody>
                        <br>
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">صندوق الفرع بالليرة</th>
                                <th class="text-center">صندوق الفرع بالدولار</th>
                                <th class="text-center"> قيمه المستودع بالليره</th>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td class="text-center"> {{ $data['boxTl'] }}</td>
                                <td class="text-center">{{ $data['boxUsd'] }}</td>
                                <td class="text-center">{{ $totalPriceTL }}</td>
                            </tr>
                        </tbody>
                        <br>
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">قيمة الدين بالليرة</th>
                                <th class="text-center">قيمة الدين بالدولار</th>
                                <th class="text-center">قيمة المستودع بالدولار</th>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td class="text-center">{{ $totalDebtsTL }}</td>
                                <td class="text-center"> {{ $TotalUSD }}$</td>
                                <td class="text-center">{{ $totalPriceUSD }}$</td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            @else
                <div class="alert alert-danger text-center">
                    عفوا لايوجد بيانات لعرضها!!!!

                </div>
            @endif
            <br>
            <br>


            {{-- الطلبات الاخيرة --}}

            <div class="card">
                <h4 class="pt-3 ">
                    <span class="text-muted fw-light mx-2">الفرع /</span> الطالبات الاخيره
                </h4>
                @if (@isset($orders) && !@empty($orders))
                    @php
                        $i = 1;
                    @endphp
                    <div class="table-responsive text-nowrap">
                        <table class="table">

                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">مسلسل</th>
                                    <th class="text-center">اسم المنتج </th>
                                    <th class="text-center">السعر المنتج بالدولر </th>
                                    <th class="text-center">السعر المنتج باليره</th>
                                    <th class="text-center">الكيمة</th>
                                    <th class="text-center"> النسبه </th>
                                    <th class="text-center">اجمالي بالدولر </th>
                                    <th class="text-center">اجمالي باليره </th>
                                    <th class="text-center">الملاحظات</th>
                                    <th class="text-center">حالة الموافقة</th>

                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($orders as $info)
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        {{-- <td class="text-center">{{ $info->user->price_categoris_id }}</td> --}}
                                        <td class="text-center">{{ $info->item->name }}</td>

                                        <td class="text-center">{{ $info->item->gumla_price_usd }}</td>
                                        <td class="text-center">{{ $info->item->gumla_price_tl }}</td>
                                        <td class="text-center">{{ $info->count }}</td>


                                        @if ($info->user->price_categoris_id != null)
                                            @php
                                                $price_id = $info->user->price_categoris_id;
                                                $price_category_items = \App\Models\PriceCategoryItem::where('price_categoris_id', $price_id)
                                                    ->where('items_id', $info->item->id)
                                                    ->first();

                                            @endphp
                                            <td
                                                class="text-center
                                           {{ $price_category_items->percent > 1 ? ' text-success' : ' text-danger' }}">
                                                {{ $price_category_items->percent }}
                                            </td>


                                            <td class="text-center">
                                                @php
                                                    $x = round(($price_category_items->percent * $info->item->gumla_price_usd * $info->count) / 100 + $info->item->gumla_price_usd * $info->count);
                                                @endphp
                                                {{ $x }}
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $x = round(($price_category_items->percent * $info->item->gumla_price_tl * $info->count) / 100 + $info->item->gumla_price_tl * $info->count);
                                                @endphp
                                                {{ $x }}
                                            </td>
                                        @else
                                            <td class="text-center">--</td>
                                            <td class="text-center">{{ $info->item->gumla_price_usd * $info->count }}</td>
                                            <td class="text-center">{{ $info->item->gumla_price_tl * $info->count }}</td>
                                        @endif

                                        <td class="text-center">{{ $info->notes }}</td>

                                        <td class="text-center"
                                            @if ($info->wait == 1) style="background-color: #ffc107 ;color:white ; font-weight: bold"
                                        @else
                                        style="background-color: green ;color:white ; font-weight: bold" @endif>
                                            {{ $info->wait == 1 ? 'في انتتظار الموافقة ' : 'تمت الموافقة' }}
                                        </td>



                                    </tr> @php
                                        $i++;
                                    @endphp
                                @endforeach

                            </tbody>
                            <br>


                        </table>
                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        عفوا لايوجد بيانات لعرضها!!!!


                    </div>
                @endif




                <br>
                <br>
                {{-- تفاصيل المخزن --}}
                <div class="card">
                    <h4 class="pt-3 ">
                        <span class="text-muted fw-light mx-2">الفرع /</span> تفاصيل المخزن
                    </h4>
                    @if (@isset($inventory) && !@empty($inventory))
                        @php
                            $i = 1;
                        @endphp
                        <div class="table-responsive text-nowrap">
                            <table class="table">

                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center"> مسلسل</th>
                                        <th class="text-center">اسم الصنف</th>
                                        <th class="text-center">سعر الشراء بالليرة</th>
                                        <th class="text-center">سعر الشراء بالدولار</th>
                                        <th class="text-center">الباقي في المستودع</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($inventory as $info)
                                        <tr>

                                            <td class="text-center">{{ $i }}</td>
                                            <td class="text-center">{{ $info->item->name }}</td>
                                            <td class="text-center">{{ $info->item->gumla_price_tl * $info->count }} </td>
                                            <td class="text-center">{{ $info->item->gumla_price_usd * $info->count }}</td>
                                            <td class="text-center">{{ $info->count }} </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach

                                </tbody>
                                <br>


                            </table>
                        </div>
                    @else
                        <div class="alert alert-danger text-center">
                            عفوا لايوجد بيانات لعرضها!!!!
                        </div>
                    @endif


                    {{--  المصاريف --}}
                    <br>
                    <br>

                    <div class="card">
                        <h4 class="pt-3 ">
                            <span class="text-muted fw-light mx-2">الفرع /</span> مصاريف الفرع
                        </h4>
                        @if (@isset($outlay) && !@empty($outlay))
                            @php
                                $i = 1;
                            @endphp
                            <div class="table-responsive text-nowrap">
                                <table class="table">

                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">مسلسل</th>
                                            <th class="text-center">اسم الفرع </th>
                                            <th class="text-center">نوع الصرف</th>
                                            <th class="text-center">العملة</th>
                                            <th class="text-center">المجموع</th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach ($outlay as $info)
                                            <tr>
                                                <td class="text-center">{{ $i }}</td>
                                                <td class="text-center">{{ $data['name'] }}</td>
                                                <td class="text-center">
                                                    @if ($info->type == 1)
                                                        <span class="text-success">رواتب</span>
                                                    @elseif ($info->type == 2)
                                                        <span class="text-info">طلبيات</span>
                                                    @elseif ($info->type == 3)
                                                        <span class="text-primary">مستلزمات المواد</span>
                                                    @else
                                                        <span class="text-danger">غير ذلك</span>
                                                    @endif
                                                </td>



                                                <td class="text-center">{{ $info->currency == 1 ? 'دولار' : 'ليرة' }}</td>
                                                <td class="text-center">{{ $info->total }}</td>

                                            </tr> @php
                                                $i++;
                                            @endphp
                                        @endforeach

                                    </tbody>
                                    <br>


                                </table>
                            </div>
                        @else
                            <div class="alert alert-danger text-center">
                                عفوا لايوجد بيانات لعرضها!!!!
                            </div>
                        @endif

                        <br><br>



                    </div>
                    {{--  مبيعات الفرع --}}

                    <br><br>
                    <div class="card">
                        <h4 class="pt-3 ">
                            <span class="text-muted fw-light mx-2">الفرع /</span> مبيعات الفرع
                        </h4>

                        @if (@isset($dataofsalesOnDay) && !@empty($dataofsalesOnDay))
                            @php
                                $i = 1;
                            @endphp
                            <div class="table-responsive text-nowrap">
                                <table class="table">

                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">مسلسل</th>
                                            <th class="text-center">اسم الفرع </th>
                                            <th class="text-center">اسم المنتج </th>
                                            <th class="text-center">الكمية</th>
                                            <th class="text-center">العملة</th>
                                            <th class="text-center">المجموع</th>


                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach ($dataofsalesOnDay as $info)
                                            <tr>
                                                <td class="text-center">{{ $i }}</td>
                                                <td class="text-center">{{ $info->user->name }}</td>
                                                <td class="text-center">{{ $info->item->name }}</td>
                                                <td class="text-center">{{ $info->count }}</td>
                                                <td class="text-center">

                                                    @if ($info->currency == 1)
                                                        <span class="text-success"> دولار</span>
                                                    @elseif ($info->currency == 2)
                                                        <span class="text-info"> ليره</span>
                                                    @else
                                                        <span class="text-danger"> غير معرفه</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $info->total }} </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach

                                    </tbody>
                                    <br>


                                </table>
                            </div>
                        @else
                            <div class="alert alert-danger text-center">
                                عفوا لايوجد بيانات لعرضها!!!!
                            </div>
                        @endif
                    </div>



                    <br><br>
                    <br><br>
                    <div class="d-flex  justify-content-center">
                        <div>
                            <a data-bs-toggle="modal" data-bs-target="#exampleModal"
                                style="color: black; font-weight: bold" class="btn btn-md btn-warning" id="bayout">
                                احسب البيوت
                            </a>
                            <a id="bayoutSifir" style="display:none;" style="color: black ;font-weight: bold"
                                class="btn btn-md btn-warning" id="bayout"
                                href="{{ route('branch.bayout', $data['id']) }}">اتمام العميلة وبدأ يوم جديد</a>
                        </div>
                        <br>
                        <div id="loading" style="display:none;">جاري حساب البيتوب</div>

                        <br><br>
                    </div>

                    <!-- Modal -->
                    {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hiddmen="true"> --}}
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">

                        <div class="modal-dialog">
                            <div class="modal-content col-6">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">...حساب البيوت</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{-- ////////// --}}
                                    <div class="container">
                                        <br /><br />
                                        <div class="row" id="looder">
                                            <div class="col-md-12">
                                                <div class="loader7">
                                                    <span class="loader-inner-1"></span>
                                                    <span class="loader-inner-2"></span>
                                                    <span class="loader-inner-3"></span>
                                                    <span class="loader-inner-4"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <br /><br />

                                        <div class="cards container " style="display: none;" id="show_info">
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <div class="card h-100">
                                                        <div class="card-body pb-0 text-center">
                                                            <div class="card-icon">
                                                                <span class="badge bg-label-primary rounded-pill p-2">
                                                                    <i class='ti ti-users ti-sm'></i>
                                                                </span>
                                                            </div>
                                                            <h5
                                                                class="card-title mb-0 py-3 mt-2 {{ $TotalTL >= 0 ? ' bg-label-info text-success' : ' bg-label-danger text-white' }}">
                                                                {{ $TotalTL }}
                                                            </h5>
                                                            <small>الحساب بالليره</small>
                                                        </div>
                                                        <div id="subscriberGained"></div>
                                                    </div>
                                                </div>

                                                <!-- Quarterly Sales -->
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <div class="card h-100">
                                                        <div class="card-body pb-0 text-center">
                                                            <div class="card-icon">
                                                                <span class="badge bg-label-danger rounded-pill p-2">
                                                                    <i class='ti ti-shopping-cart ti-sm'></i>
                                                                </span>
                                                            </div>
                                                            <h5
                                                                class="card-title  mb-0 py-3 round mt-2{{ $TotalUSD >= 0 ? ' bg-label-info text-success' : ' bg-label-danger text-white' }}">
                                                                {{ $TotalUSD }}$</h5>
                                                            <small>الحساب بالدولر </small>
                                                        </div>
                                                        <div id="quarterlySales"></div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    {{-- ////////// --}}

                                </div>
                                {{-- <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        // انتظر حتى تحميل الصفحة ثم قم بتنفيذ الوظيفة بعد 3 ثوان
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('looder');
            var modal1 = document.getElementById('show_info');

            setTimeout(function() {
                console.log('fffffffffffffffffffff')
                modal.style.display = 'none';
                modal1.style.display = 'block';
            }, 3000); // تأخير 3 ثواني قبل إخفاء النافذة
        });
    </script>


    <script src="{{ asset('assets/admin/js/branch.js') }}"></script>
@endsection
