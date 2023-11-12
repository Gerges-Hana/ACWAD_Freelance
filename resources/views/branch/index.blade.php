@extends('layouts/layoutMaster')

{{-- @section('title', 'ACWA') --}}
<title>ACWA</title>

@section('vendor-style')
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
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <!-- Form Validation -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>

    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script>
        $(function(e) {
            //file export datatable
            var table = $('#example').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis'],
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ ',
                }
            });
            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');

            $('#example1').DataTable({
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                }
            });
            $('#example2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                }
            });
            var table = $('#example-delete').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                }
            });
            $('#example-delete tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $('#button').click(function() {
                table.row('.selected').remove().draw(false);
            });

            //Details display datatable
            $('#example-1').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                },
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details for ' + data[0] + ' ' + data[1];
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                            tableClass: 'table border mb-0'
                        })
                    }
                }
            });
        });
    </script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script>
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








    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">بيانات حساب /</span> الفرع
    </h4>

    {{--  --}}

    @can(' اضافه الفرع')
        <a href="{{ route('branch.create') }}" class="mb-4 btn btn-primary waves-effect waves-light">اضافة جديد </a>
    @endcan
    <br>





    @if (@isset($data) && !@empty($data) && count($data) > 0)
        <div class='card'>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table key-buttons text-md-nowrap"class=" table key-buttons  " id="example2">

                        <thead class="custom_thead table-dark">
                            <tr class="">
                                <th>المتسلسل </th>
                                <th>الاسم </th>
                                <th>الكود </th>
                                <th>رقم الحساب</th>
                                <th>الهاتف</th>
                                <th> العنوان</th>

                                <th class="text-center">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @if (isset($result))
                                @if ($result->count())
                                    @foreach ($result as $result)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $result->name }}</td>
                                            <td>{{ $result->id }}</td>
                                            <td>{{ $result->account_number }}</td>
                                            <td>{{ $result->phone }}</td>
                                            <td>{{ $result->address }}</td>


                                        </tr>
                                        @php
                                            $i++;
                                        @endphp

                                        {{-- =====================delet modal===================== --}}
                                        <div class="modal fade " id="deletBranch{{ $info->id }}" tabindex="-1"
                                            aria-hidden="true">

                                            <div class="col-6  modal-dialog modal-lg modal-simple modal-edit-user ">
                                                <div class="modal-content   w-50 m-auto">
                                                    <div class="modal-body p-0">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                        <div class="text-center mb-2">
                                                            <h3 class="mb-2">تأكيد الحذف</h3>
                                                            <p class="text-muted"></p>
                                                        </div>
                                                        @if (isset($info))
                                                            <form id="deletBranchForm" method="POST"
                                                                action="{{ route('branch.delete', $info->id) }}"
                                                                class="row g-3">
                                                                @csrf
                                                                @method('delete')
                                                                <div class="modal-body">
                                                                    هل أنت متأكد أنك تريد حذف هذا العنصر؟
                                                                </div>
                                                                <div class="col-12 text-center">
                                                                    <button type="submit"
                                                                        class="btn btn-danger me-sm-3 me-1">حذف</button>
                                                                    <button type="reset" class="btn btn-label-secondary"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close">الغاء</button>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <p>لا توجد بيانات لحذفها.</p>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- =====================delet modal===================== --}}
                                    @endforeach
                                @else
                                    <p> No result found </p>
                                @endif
                            @else
                                @foreach ($data as $info)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $info->name }}</td>
                                        <td>{{ $info->id }}</td>
                                        <td>{{ $info->account_number }}</td>
                                        <td>{{ $info->phone }}</td>
                                        <td>{{ $info->address }}</td>
                                        <td class="text-center">
                                            @can('تعديل الفرع')
                                                <a href="{{ route('branch.edit', $info->id) }}"
                                                    class="btn btn-sm btn-warning">تعديل</a>
                                            @endcan

                                            @can('عرض الفرع')
                                                <a href="{{ route('branch.show', $info->id) }}"
                                                    class="btn btn-sm btn-info">عرض</a>
                                            @endcan
                                            @can('حذف الفرع')
                                                <a href="{{ route('branch.delete', $info->id) }}"
                                                    class="btn btn-sm btn-danger are_you_sure"
                                                    data-bs-target="#deletBranch{{ $info->id }}"
                                                    data-bs-toggle="modal">حذف</a>
                                            @endcan



                                        </td>

                                    </tr>
                                    @php
                                        $i++;
                                    @endphp

                                    {{-- =====================delet modal===================== --}}
                                    <div class="modal fade " id="deletBranch{{ $info->id }}" tabindex="-1"
                                        aria-hidden="true">

                                        <div class="col-6  modal-dialog modal-lg modal-simple modal-edit-user ">
                                            <div class="modal-content   w-50 m-auto">
                                                <div class="modal-body p-0">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                    <div class="text-center mb-2">
                                                        <h3 class="mb-2">تأكيد الحذف</h3>
                                                        <p class="text-muted"></p>
                                                    </div>
                                                    @if (isset($info))
                                                        <form id="deletBranchForm" method="POST"
                                                            action="{{ route('branch.delete', $info->id) }}"
                                                            class="row g-3">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-body">
                                                                هل أنت متأكد أنك تريد حذف هذا العنصر؟
                                                            </div>
                                                            <div class="col-12 text-center">
                                                                <button type="submit"
                                                                    class="btn btn-danger me-sm-3 me-1">حذف</button>
                                                                <button type="reset" class="btn btn-label-secondary"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close">الغاء</button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <p>لا توجد بيانات لحذفها.</p>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- =====================delet modal===================== --}}
                                @endforeach
                            @endif


                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <br>
        {{-- {{ $data->links() }} --}}
    @else
        <div class="alert alert-danger text-center">
            عفوا لايوجد بيانات لعرضها!!!!
        </div>
    @endif

    </table>


    {{-- @include('_partials/_modals/modal-delete-branch') --}}
@endsection
