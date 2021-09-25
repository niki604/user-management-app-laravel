@extends('master')

@section('content')

    <!-- Modal -->
    <form method="post" action="/users" id="AddUserForm" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul id="saveform_errlist"></ul>

                    
                    <div class="form-group mb-3">
                        <label for="">Name</label>
                        <input type="text" class="name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input type="text" class="email form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Phone</label>
                        <input type="text" class="phone form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Photo</label>
                        <input type="file" name="image" class="image form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Password</label>
                        <input type="password" class="password form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary add_user">Save</button>
                </div>
            
            </div>
        </div>
    </div>
    </form>

<form method="post" id="EditUserForm" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="EditUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit & Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="updateform_errlist"></ul>
                    <input type="hidden" id="edit_user_id">
                    <div class="form-group mb-3">
                        <label for="">Name</label>
                        <input type="text" id="edit_name" class="name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input type="text" id="edit_email" class="email form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Phone</label>
                        <input type="text" id="edit_phone" class="phone form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Photo</label>
                        <input type="file" id="edit_image" class="image form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update_user">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>



    <div class="modal fade" id="DeleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="delete_user_id">
                    <h4>Are you sure you want to delete?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete_user">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="ml-3 relative">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-primary" type="submit" style="float: right" onclick="event.preventDefault();
            this.closest('form').submit();">Log Out</button>
        </form>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                
                <div id="saveform_success"></div>
                <div class="card">
                    <div class="card-header">
                        <h4>Users Data
                            <a href="#" class="btn btn-primary float-end btn-sm" data-bs-toggle="modal"
                                data-bs-target="#AddUserModal">Add User</a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th>Slno</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            fetchuser();

            function fetchuser() {
                $.ajax({
                    type: 'GET',
                    url: '/fetch-user',
                    dataType: "json",
                    success: function(result) {
                        //console.log(result.users);
                        $('tbody').html("");
                        $.each(result.users, function(key, item) {
                            $('tbody').append('<tr>\
        								<td>' + item.id + '</td>\
        								<td>' + item.name + '</td>\
        								<td>' + item.email + '</td>\
                                        <td>' + item.phone + '</td>\
        								<td><button type="button" class="edit_button btn btn-primary btn-sm" value="' + item.id + '">Edit</button></td>\
        								<td><button type="button" class="delete_button btn btn-primary btn-sm btn-danger" value="' + item.id + '">Delete</button></td>\
        							</tr>');

                        });
                    }
                });
            }
            $(document).on('click', '.edit_button', function(e) {
                e.preventDefault();
                var user_id = $(this).val();
                //console.log(user_id);
                $('#EditUserModal').modal('show');
                $.ajax({
                    type: 'GET',
                    url: '/edit-user/' + user_id,
                    success: function(result) {
                        //console.log(result);
                        if (result.status == 404) {
                            $('#saveform_errlist').html("");
                            $('#saveform_success').addClass("alert alert-danger");
                            $('#saveform_success').text(result.message);
                        } else {
                            $('#edit_name').val(result.users.name);
                            $('#edit_email').val(result.users.email);
                            $('#edit_phone').val(result.users.phone);
                            $('#edit_password').val(result.users.password);
                            $('#edit_user_id').val(user_id);
                        }
                    }
                });
            });
            $(document).on('submit', '#AddUserForm', function(e) {
                e.preventDefault();
                var name = $('.name').val();
                var email = $('.email').val();
                var phone = $('.phone').val();
                var password = $('.password').val();
                var str_image = $('.image').val();

                var imgstr = str_image.split("\\");
                var image = imgstr[2];

                var data = {
                    'name': name,
                    'email': email,
                    'phone': phone,
                    'password': password,
                    'image': image,
                }

                //console.log(data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '/users',
                    data: data,
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 400) {
                            $('#saveform_errlist').html("");
                            $('#saveform_errlist').addClass("alert alert-danger");
                            $.each(result.errors, function(key, err_values) {
                                $('#saveform_errlist').append('<li>' + err_values +
                                    '</li>');

                            });
                        } else {
                            $('#saveform_errlist').html("");
                            $('#saveform_success').addClass("alert alert-success");
                            $('#saveform_success').text(result.message);
                            $('#AddUserModal').modal('hide');
                            $('#AddUserModal').find('input').val('');
                            fetchuser();
                        }
                    }
                });

            });
            $(document).on('submit', '#EditUserForm', function(e) {
                e.preventDefault();
                var user_id = $('#edit_user_id').val();
                var name = $('#edit_name').val();
                var email = $('#edit_email').val();
                var phone = $('#edit_phone').val();
                var str_image = $('.image').val();

                var imgstr = str_image.split("\\");
                var image = imgstr[2];

                var data = {
                    'name': name,
                    'email': email,
                    'phone': phone,
                    'image': image,
                }

                //console.log(data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'PUT',
                    url: '/update-user/' + user_id,
                    data: data,
                    dataType: "json",
                    success: function(result) {
                        //console.log(result);
                        if (result.status == 400) {
                            $('#updateform_errlist').html("");
                            $('#updateform_errlist').addClass("alert alert-danger");
                            $.each(result.errors, function(key, err_values) {
                                $('#updateform_errlist').append('<li>' + err_values +
                                    '</li>');

                            });
                        } else if (result.status == 404) {
                            $('#updateform_errlist').html("");
                            $('#saveform_success').addClass("alert alert-success");
                            $('#saveform_success').text(result.message);
                        } else {
                            $('#updateform_errlist').html("");
                            $('#saveform_success').addClass("alert alert-success");
                            $('#saveform_success').text(result.message);
                            $('#EditUserModal').modal('hide');
                            $('#EditUserModal').find('input').val('');
                            fetchuser();
                        }
                    }
                });

            });
            $(document).on('click', '.delete_button', function(e) {
                e.preventDefault();
                var user_id = $(this).val();
                console.log(user_id);
                $('#delete_user_id').val(user_id);
                $('#DeleteUserModal').modal('show');
            });
            $(document).on('click', '.delete_user', function(e) {
                e.preventDefault();
                var user_id = $('#delete_user_id').val();
                //console.log(user_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'DELETE',
                    url: '/delete-user/' + user_id,
                    success: function(result) {
                        //console.log(result);
                        $('#saveform_success').addClass("alert alert-success");
                        $('#saveform_success').text(result.message);
                        $('#DeleteUserModal').modal('hide');
                        fetchuser();
                    }
                });
            });

        });
    </script>

@endsection
