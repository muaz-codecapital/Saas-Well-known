@extends('layouts.primary')

@section('head')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="card bg-purple-light mb-3 mt-4">
        <div class="card-header bg-purple-light pb-0 p-3">
            <div class="row">
                <div class="col-md-8">
                    <h6>{{__('Users')}} ({{$users_count_on_this_workspace}})</h6>

                    @if($maximum_allowed_users)
                        <p>{{__('Current plan maximum allowed users:')}} {{$maximum_allowed_users}}</p>
                    @endif
                </div>
                <div class="col-md-4 text-right">

                    @if($users_count_on_this_workspace < $maximum_allowed_users)
                        <a class="btn bg-gradient-dark mb-0" href="/new-user"><i class="fas fa-plus"></i>&nbsp;&nbsp;
                            {{__(' Add New User')}}
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-body mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="cloudonex_table">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('Name')}}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Email')}}</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('Phone')}}</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                            <tbody>
                            @foreach($staffs as $staff)

                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if(empty($staff['photo']))
                                                    <div
                                                        class="avatar avatar-md bg-success-light  border-radius-md p-2 ">
                                                        <h6 class="text-success ">{{$staff->first_name['0']}}{{$staff->last_name['0']}}</h6>
                                                    </div>
                                                @else

                                                    <img src="{{PUBLIC_DIR}}/uploads/{{$staff->photo}}"
                                                         alt="" class="avatar avatar-md shadow-sm">
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center px-3">
                                                <h6 class="mb-0 text-sm">{{$staff->first_name}} {{$staff->last_name}}</h6>
                                                <p class="text-xs text-secondary mb-0">{{$staff->email}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$staff->email}}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span
                                            class="text-secondary text-xs font-weight-bold">{{$staff->mobile_number}}</span>
                                    </td>
                                    <td class="align-middle text-right">
                                        <div class="ms-auto">

                                            @if(!$workspace->owner_id || $staff->id != $workspace->owner_id )
                                                <a class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                   href="javascript:void(0)"
                                                   onclick="confirmDeleteStaff({{$staff->id}}, '{{$staff->first_name}} {{$staff->last_name}}', '{{$staff->email}}')">
                                                    <i class="far fa-trash-alt me-2"></i>{{__('Delete')}}
                                                </a>
                                            @endif


                                            <a class="btn btn-link text-dark px-3 mb-0"
                                               href="/user-edit/{{$staff->id}}"><i
                                                    class="fas fa-pencil-alt text-dark me-2"
                                                    aria-hidden="true"></i>{{__('Edit')}}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        "use strict";
        $(document).ready(function () {
            $('#cloudonex_table').DataTable();
        });

        function confirmDeleteStaff(staffId, staffName, staffEmail) {
            Swal.fire({
                title: '{{__("Delete User")}}',
                html: `
                    <div class="text-start">
                        <p class="mb-3">{{__("Are you sure you want to delete this user?")}}</p>
                        <div class="alert alert-warning" style="color: #252f40 !important;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>{{__("Warning:")}}</strong> {{__("This action cannot be undone. All user data will be permanently deleted.")}}
                        </div>
                        <div class="mb-3">
                            <strong>{{__("User:")}}</strong> ${staffName}<br>
                            <strong>{{__("Email:")}}</strong> ${staffEmail}
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i>{{__("Yes, Delete User")}}',
                cancelButtonText: '<i class="fas fa-times me-1"></i>{{__("Cancel")}}',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'swal2-popup-custom',
                    title: 'swal2-title-custom',
                    content: 'swal2-content-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: '{{__("Deleting...")}}',
                        text: '{{__("Please wait while we delete the user.")}}',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Redirect to delete URL
                    window.location.href = `/delete/staff/${staffId}`;
                }
            });
        }
    </script>

    <style>
    .swal2-popup-custom {
        border-radius: 12px !important;
    }

    .swal2-title-custom {
        color: #dc3545 !important;
        font-weight: 600 !important;
    }

    .swal2-content-custom {
        text-align: left !important;
    }

    .swal2-actions .swal2-confirm {
        border-radius: 6px !important;
        font-weight: 500 !important;
    }

    .swal2-actions .swal2-cancel {
        border-radius: 6px !important;
        font-weight: 500 !important;
    }
    </style>
@endsection


