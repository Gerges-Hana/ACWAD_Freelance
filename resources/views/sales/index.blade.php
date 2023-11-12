@extends('layouts/layoutMaster')

{{-- @section('title', 'Analytics') --}}
<title>ACWAD</title>

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
@endsection

@section('content')



    <h4 class="pt-3 ">
        <span class="text-muted fw-light mx-2">جدول /</span> المبيعات
    </h4>



    {{-- ======================================== --}}
    <div class="container">
        <div class="row">

            <!-- Earning Reports -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100 p-4">

                    <div class="card-title mb-0  ">
                        <h5 class="mb-0">مجموع المبيعات بالليره </h5>
                        <div class="d-flex my-2">
                            <div class="card-icon">
                                <span class="badge bg-label-success rounded-pill p-2">
                                    <i class="ti ti-server ti-sm"></i>
                                </span>
                            </div>
                            <h6 class="text-muted m-2">الحسب يساوي :: {{ $total_sales_tl }}</h6>

                        </div>
                    </div>
                </div>
            </div>
            <!--/ Earning Reports -->

            <!-- Support Tracker -->

            <div class="col-lg-6 mb-4">
                <div class="card h-100 p-4">

                    <div class="card-title mb-0 ">
                        <h5 class="mb-0">مجموع المبيعات بالدولار </h5>
                        <div class="d-flex my-2">
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
                                    <i class="ti ti-currency-dollar ti-sm"></i>

                                </span>
                            </div>
                            <h6 class="text-muted m-2">الحساب يساودس :: {{ $total_sales_usd }}</h6>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="card">
        <h5 class="card-header">بيانات جدول المبيعات</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                @if (isset($data) && !$data->isEmpty())
                    @php
                        $i = 1;
                    @endphp
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">مسلسل</th>
                            <th class="text-center">اسم الفرع </th>
                            <th class="text-center">اسم المنتج </th>
                            <th class="text-center">الكيمة</th>
                            <th class="text-center">العملة</th>
                            <th class="text-center">المجموع</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($data as $info)
                            <tr>
                                <td class="text-center">{{ $i }}</td>
                                <td class="text-center">{{ $info->user->name }}</td>
                                <td class="text-center">{{ $info?->item?->name }}</td>
                                <td class="text-center">{{ $info->count }}</td>
                                <td class="text-center">
                                    @if ($info->currency == 1)
                                        <span class="text-success">دولار</span>
                                    @elseif ($info->currency == 2)
                                        <span class="text-info">ليرة</span>
                                    @else
                                        <span class="text-danger">غير ذلك</span>
                                    @endif
                                </td>

                                <td class="text-center">{{ $info->total }}</td>
                            </tr> @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
            </table>
        @else
            <div class="alert alert-danger text-center">
                عفوا لايوجد بيانات لعرضها!!!!
            </div>
            @endif
        </div>
    </div>
    {{-- =================================================== --}}



@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/treasuries.js') }}"></script>
@endsection
