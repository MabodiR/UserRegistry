<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Listing</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom CSS -->
    <style>
        /* Stripe the table rows */
        table.table-striped tbody tr:nth-child(odd) {
            background-color: #ccc;
        }
         /* Set font to Helvetica */
        body {
            font-family: "Helvetica", Arial, sans-serif;
        }
        .red {
            color: red;
            }
    </style>

</head>
<body>

<!-- Slider Section -->
<div id="slider" class="carousel slide" data-ride="carousel">
    <!-- Add your slider content here -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/img/slider-image1.jpg" alt="Slider Image 1" class="d-block w-100" style="height: 450px; object-fit: cover;">
            <div class="carousel-caption d-flex justify-content-center align-items-center h-100">
                <h1>User Listing</h1>
            </div>
        </div>
    </div>
</div>

<!-- User Table -->
<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#addUserModal">Add New User</button>
    </div>
    <div class="table-responsive"> <!-- Add the table-responsive class here -->
        <table id="userTable" class="table table-striped">
            <tbody>
                <!-- Loop through users from Laravel to display in the table -->
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }} {{ $user->surname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <i class="fa fa-trash-o red delete-user" data-user-id="{{ $user->id }}"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="Post" action="/user-listings/store">
                {{ csrf_field() }} <!-- Add Laravel CSRF token -->

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                        <div class="invalid-feedback">
                            Please enter a name.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="surname">Surname</label>
                        <input type="text" class="form-control" name="surname" id="surname" placeholder="Enter surname">
                        <div class="invalid-feedback">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                        <div class="invalid-feedback">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" name="position" id="position" placeholder="Enter position">
                        <div class="invalid-feedback">
                        
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark d-none" id="loadingButton" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn " data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" id="saveButton">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- HTML Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Please confirm that you would like to delete this user?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-dark d-none" id="deleteLoadingButton" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-dark" id="confirmDeleteBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>

</body>

<!-- Include Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>

<!-- Initialize the modal and DataTables -->
<script>
$(document).ready(function() {

    // Show the modal when the "Add New User" button is clicked
    $('#addUserModalBtn').click(function() {
        $('#addUserModal').modal('show');
    });

      // Show the modal when the "Add New User" button is clicked
      $('#addUserModalBtn').click(function () {
        $('#addUserModal').modal('show');
      });

      $('#saveButton').click(function () {
        // Disable the save button and show the loading button
        $('#loadingButton').removeClass('d-none');

        // Validate the form
        var form = $('#addUserForm')[0];
        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          // Scroll to the first invalid field
          $('html, body').animate({
            scrollTop: $('.form-control:invalid').first().offset().top - 50
          }, 500);
          // Enable the save button and hide the loading button
          $('#loadingButton').addClass('d-none');
          return;
        }

        // Get the form data
        var name = $('#name').val();
        var surname = $('#surname').val();
        var email = $('#email').val();
        var position = $('#position').val();

        // Create a data object with the form data and CSRF token
        var data = {
          _token: $('meta[name="csrf-token"]').attr('content'),
          name: name,
          surname: surname,
          email: email,
          position: position
        };

        // Delay in milliseconds (2 seconds in this case)
        setTimeout(function () {
        // Submit the form data to the specified URL
        $.ajax({
          url: '/user-listings/store',
          type: 'POST',
          data: data,
          success: function (response) {

            
              form.reset();
              form.classList.remove('was-validated');
              $('.invalid-feedback').empty();
              $('#addUserModal').modal('hide');

                location.reload();
           
          },
          error: function (xhr, status, error) {
            // Handle the error response here
            console.log(xhr.responseText);

            // Enable the save button and hide the loading button
            $('#loadingButton').addClass('d-none');

            // Handle validation errors
            if (xhr.status === 422) {
              var errors = xhr.responseJSON.errors;
              // Clear previous error messages
              $('.invalid-feedback').empty();
              // Display error messages for each field
              $.each(errors, function (field, messages) {
                var inputField = $('#' + field);
                inputField.addClass('is-invalid');
                var errorContainer = inputField.next('.invalid-feedback');
                errorContainer.html(messages.join('<br>'));
              });
            }
          }
        });
      }, 2000);

      });



    //delete user section
    var userIdToDelete;
    var clickedIcon;

    $('.delete-user').on('click', function() {
        userIdToDelete = $(this).data('user-id');
        $('#deleteLoadingButton').removeClass('d-none');
        clickedIcon = $(this); // Store the reference to $(this)
    });

    $('#confirmDeleteBtn').on('click', function() {
        $('#confirmDeleteModal').modal('show'); //show modal
        setTimeout(function() {

        $('#confirmDeleteModal').modal('hide'); //hide loading button

        $.ajax({
            url: '/user-listings/destroy/' + userIdToDelete,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle success response
                clickedIcon.closest('tr').remove(); // Use the stored reference to remove the table row
                $('#deleteLoadingButton').addClass('d-none');
            },
            error: function(xhr, status, error) {
                // Handle error response, if needed
                console.error(error);
            }
        });
    }, 3000); // Delay in milliseconds (3 seconds in this case)

    });


});
</script>
</html>
