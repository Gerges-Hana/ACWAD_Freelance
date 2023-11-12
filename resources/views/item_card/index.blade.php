@extends('layouts/layoutMaster')

{{-- @section('title', 'DataTables - Tables') --}}
<title>ACWAD</title>

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

    {{-- ++++++++++++++++++++++++++++++++++++++++ --}}

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
    <h4 class="pt-3 ">
        <span class="text-muted fw-light mx-2"> بيانات /</span> الاصناف
    </h4>
    @can('اضافة صنف')
        <a href="{{ route('itemcard.create') }}" class="mb-4 btn btn-primary waves-effect waves-light">اضافة جديد </a>
    @endcan
    <br>

    <div class="card">


        <div class="card-body">


            {{-- <div class="row ">
                <div class="col-md-4  ">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                        <input type="text" name="search_by_text" class="form-control" placeholder=" بحث بالاسم الصنف "
                            aria-label="Search..." aria-describedby="basic-addon-search31">
                    </div>
                </div> --}}
            {{-- ===============البحث بنوع الصنف============== --}}
            {{-- <div class="col-md-4 user_status">
                    <select id="FilterTransaction" class="form-select text-capitalize">
                        <option value=""> البحث بنوع الصنف</option>
                        <option value="all" class="text-capitalize">البحث بالكل</option>
                        <option value="1" class="text-capitalize">مخزني</option>
                        <option value="2" class="text-capitalize">استهلاك بتريخ الصلاحيه</option>
                        <option value="3" class="text-capitalize">عهد</option>
                    </select>
                    @error('inv_itemcard_categories_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}
            {{-- ============================= --}}




            {{-- <div class="col-md-4">
                    <div class="col-sm">
                        {{-- <label>البحث بفئة الصنف</label> --}
                        <select id="inv_itemcard_categories_id_search" class="select2 form-select" data-allow-clear="true"
                            name="inv_itemcard_categories_id_search">
                            <option value="">البحث بفئة الصنف</option>
                            <option value="all">البحث بالكل</option>
                            @if (@isset($inv_itemcard_categorie_name) && !@empty($inv_itemcard_categorie_name))
                                @foreach ($inv_itemcard_categorie_name as $info)
                                    <option value="{{ $info->id }}">{{ $info->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('inv_itemcard_categories_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
            <br>
            <br>
        </div>
        <br>


        <div id="ajax_responce_serarchDiv" class="col-md-12">



            <div class="card-datatable table-responsive">
                @if (isset($data) && !$data->isEmpty())
                    @php
                        $i = 1;
                    @endphp

                    {{--
<div class="card-body">
  <div class="table-responsive">
      <table id="example" class="table key-buttons text-md-nowrap">
       </table>
</div>
</div> --}}
                    <div class='card'>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table key-buttons text-md-nowrap"class=" table key-buttons  " id="example2">
                                    <thead>
                                        <tr>
                                            <th>مسلسل</th>
                                            <th>الاسم</th>
                                            <th>الفئة</th>
                                            <th>سعر الجملة بالليرة</th>
                                            <th>سعر الجملة بالدولار</th>
                                            <th>الكمية</th>
                                            <th>حالة التفعيل</th>
                                            <th>الصورة</th>
                                            <th class="text-center">العمليات</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $info)
                                            <tr>
                                                <td class="p-0 text-center ">{{ $i }}</td>
                                                <td class="p-0 text-center ">{{ $info->name }}</td>
                                                {{-- <td>{{ $info->categori_id }}</td> --}}
                                                <td>
                                                    @php
                                                        $category = App\Models\ItemCategory::find($info->categori_id);
                                                        if ($category) {
                                                            echo $category->name;
                                                        } else {
                                                            echo 'الفئة غير موجودة';
                                                        }
                                                    @endphp
                                                </td>
                                                <td class="p-0 text-center ">{{ $info->gumla_price_tl }}</td>
                                                <td class="p-0 text-center ">{{ $info->gumla_price_usd }}</td>
                                                <td class="p-0 text-center ">{{ $info->count }}</td>


                                                </td>
                                                <td>
                                                    <p class="{{ $info->active == 1 ? 'text-success' : 'text-danger' }}">
                                                        {{ $info->active == 1 ? 'مفعل' : 'معطل' }}
                                                    </p>
                                                </td>


                                                <td>
                                                    <img class="custom_imgm "
                                                        src="{{ asset('assets/admin/uploads') . '/' . $info->photo }}"
                                                        alt="الصنف" style="width: 50px; height: 50px; border-radius: px">
                                                </td>
                                                <td class="p-0 text-center ">
                                                    @can('تعديل صنف')
                                                        <a href="{{ route('itemcard.edit', $info->id) }}"
                                                            class="btn btn-sm btn-label-warning">تعديل</a>
                                                    @endcan
                                                    @can('حذف صنف')
                                                        <a href="{{ route('itemcard.delete', $info->id) }}"
                                                            class="btn btn-sm btn-label-danger  are_you_sure"
                                                            data-bs-target="#delet{{ $info->id }}"
                                                            data-bs-toggle="modal">حذف</a>
                                                    @endcan


                                                </td>

                                                {{-- ================================ --}}
                                                <div class="modal fade " id="delet{{ $info->id }}" tabindex="-1"
                                                    aria-hidden="true">

                                                    <div class="col-6  modal-dialog modal-lg modal-simple modal-edit-user ">
                                                        <div class="modal-content   w-50 m-auto">
                                                            <div class="modal-body p-0">
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                                <div class="text-center mb-2">
                                                                    <h3 class="mb-2">تأكيد الحذف</h3>
                                                                    <p class="text-muted"></p>
                                                                </div>
                                                                @if (isset($info))
                                                                    <form id="deletForm" method="POST"
                                                                        action="{{ route('itemcard.delete', $info->id) }}"
                                                                        class="row g-3">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <div class="modal-body">
                                                                            هل أنت متأكد أنك تريد حذف هذا العنصر؟
                                                                        </div>
                                                                        <div class="col-12 text-center">
                                                                            <button type="submit"
                                                                                class="btn btn-danger me-sm-3 me-1">حذف</button>
                                                                            <button type="reset"
                                                                                class="btn btn-label-secondary"
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
                                                {{-- ================================ --}}
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
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
            </div>
        </div>

        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header">
                <a href="{{ route('itemcard.create') }}" class="h5 btn-close text-reset"> اضافة جديدة</a>

            </div>

        </div>
    </div>

    </div>



    @include('_partials/_modals/modal-delete-ItemCard')
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/inv_itemcard.js') }}"></script>
@endsection
