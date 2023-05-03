<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User View</title>
    <?php include(__DIR__ . '/../components/header.php') ?>
    <style>
        #errors {
            color: red;
        }

        #back {
            color: white;
            font-weight: bold;
        }

        .container {
            display: flex;
            flex-direction: column;
            padding: 48px;
            border-radius: 8px;
            box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.2);
        }

        #user-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 48px;
        }

        #header-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 32px;
        }

        #delete-user-form {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin: 0;
        }

        #delete-user-form-submit {
            background-color: #ff0000;
            color: white;
            padding: 16px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            border: none;
            border-radius: 3px;
            transition: opacity 0.1s ease-in-out;
        }

        #delete-user-form-submit:hover {
            opacity: 0.9;
            cursor: pointer;

        }
    </style>
</head>

<body>
<div id="header">
    <h1 id="user-full-name"></h1>
    <div id="header-actions">
        <a id="back" href="/">Back</a>
        <a id="header-action" href="#">Edit User</a>
        <form id="delete-user-form">
            <input type="hidden" id="id" name="id" value="">
            <button id="delete-user-form-submit" type="submit">Delete User</button>
        </form>
    </div>
</div>

<div id="content">
    <div id="errors"></div>

    <div id="user-info">
        <div class="container">
            <h1>Personal Information</h1>
            <ul>
                <li id="gender"></li>
                <li id="date_of_birth"></li>
                <li id="ni_number"></li>
                <li id="initials"></li>
            </ul>
        </div>
        <div class="container">
            <h1>Location</h1>
            <ul>
                <li id="address"></li>
                <li id="town"></li>
                <li id="postcode"></li>
            </ul>
        </div>
        <div class="container">
            <h1>Phone Numbers</h1>
            <ul>
                <li id="mobile_tel"></li>
                <li id="home_tel"></li>
                <li id="other_tel"></li>
            </ul>
        </div>
        <div class="container">
            <h1>Other Contact Information</h1>
            <ul>
                <li id="emergency_contact_name"></li>
                <li id="personal_email"></li>
            </ul>
        </div>
    </div>
</div>
</body>

<script>
    window.onload = async () => {
        // First check if the id parameter is present and is a number
        const id = new URLSearchParams(window.location.search).get('id');
        if (!id || isNaN(id)) {
            document.getElementById('errors').innerHTML = 'Error: id parameter is missing or not a number';
            document.getElementById('user-info').remove();
            document.getElementById('delete-user-form').remove();
            return;
        }

        // Fetch the user information from the server
        const response = await fetch(`/api/user?id=${id}`);
        if (!response.ok) {
            document.getElementById('errors').innerHTML = `Error fetching user with id ${id}`;
            document.getElementById('user-info').remove();
            document.getElementById('delete-user-form').remove();
            return;
        }

        // On success, set the user information
        const user = await response.json();

        // Set the header information and edit link
        document.getElementById('header-action').href = `/edit?id=${user.id}`;
        document.getElementById('user-full-name').textContent = `${user.title} ${user.first_name} ${user.surname} (${user.informal_name || 'No informal name'})`;

        // Set the delete form id
        document.getElementById('id').value = user.id;


        // Location Information
        document.getElementById('address').textContent = `Address: ${user.address}`;
        document.getElementById('town').textContent = `Town: ${user.town || 'N/A'}`;
        document.getElementById('postcode').textContent = `Postcode: ${user.postcode}`;

        // Personal Information
        document.getElementById('gender').textContent = `Gender: ${user.gender}`;
        document.getElementById('date_of_birth').textContent = `Date of Birth: ${user.date_of_birth || 'N/A'}`;
        document.getElementById('ni_number').textContent = `NI Number: ${user.ni_number || 'N/A'}`;
        document.getElementById('initials').textContent = `Initials: ${user.initials || 'N/A'}`;

        // Contact Information
        document.getElementById('mobile_tel').textContent = `Mobile Number: ${user.mobile_tel || 'N/A'}`;
        document.getElementById('home_tel').textContent = `Home Number: ${user.home_tel || 'N/A'}`;
        document.getElementById('other_tel').textContent = `Other Number: ${user.other_tel || 'N/A'}`;
        document.getElementById('personal_email').textContent = `Email: ${user.personal_email || 'N/A'}`;
        document.getElementById('emergency_contact_name').textContent = `Emergency Contact: ${user.emergency_contact_name || 'N/A'}`;
    };

    // Delete User Form Submission Handler
    document.getElementById('delete-user-form').addEventListener('submit', async (event) => {
        // Confirm with the user before deleting
        event.preventDefault();
        if (!confirm('Are you sure you want to delete this user?')) {
            return;
        }

        // Send the delete request to the server
        const response = await fetch(`/api/delete`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(new FormData(event.target)))
        });

        // If the request wasn't successful, show an error message to the user
        if (!response.ok) {
            const error = await response.json();
            document.getElementById('errors').innerHTML = error.message;
            return;
        }

        // If the request was successful, alert the user and redirect them to the home page
        alert('User deleted successfully');
        window.location.href = '/';
    });
</script>
</html>