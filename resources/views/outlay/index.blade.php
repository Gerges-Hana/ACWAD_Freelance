@extends('layouts/layoutMaster')

{{-- @section('title', 'Analytics') --}}
<title>ACWA</title>

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
@section('title')
    المصاريف
@endsection
@section('contentHeader')
    المصاريف
@endsection
@section('contentHeaderLink')
    <a href="{{ route('outlay.index') }}"> عرض</a>
@endsection
@section('contentHeaderActive')
    جدول المصاريف
@endsection
@section('content')



    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card_title_center">بيانات حركة الصندوق</h4>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                @if (isset($data) && !$data->isEmpty())
                    @php
                        $i = 1;
                    @endphp
                    <table class="datatables-users table">
                        <thead class="border-top table-dark">
                            <tr>
                                <th class="text-center">مسلسل</th>
                                <th class="text-center">اسم الفرع </th>
                                <th class="text-center"> نوع الحركه </th>
                                <th class="text-center">العملة</th>
                                <th class="text-center">المبلغ</th>
                                <th class="text-center">التاريخ</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td class="text-center">{{ $info->user->name }}</td>
                                    <td class="text-center">{{ $info?->outlayCategory->name }}</td>
                                    <td class="text-center">{{ $info->currency == 2 ? 'ليرة' : 'دولار' }}</td>
                                    <td class="text-center">{{ $info->total }}</td>
                                    <td class="text-center">
                                        {{ $info?->created_at?->format('d-m-Y') }}

                                        {{-- الساعة  {{ $info->created_at->format('H:i:s') }} --}}
                                    </td>



                                </tr> @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="avatar-initial rounded text-center p-3 bg-label-danger">
                        عفوا لايوجد بيانات لعرضها!!!!
                    </div>
                @endif
            </div>
        </div>
        <!-- Offcanvas to add new user -->

    </div>

@endsection
