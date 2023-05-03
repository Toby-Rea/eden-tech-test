<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <?php include(__DIR__ . '/../components/header.php') ?>
    <style>
        form {
            width: 40%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
        }

        form label {
            font-weight: bold;
            margin-top: 1em;
        }

        form label.required::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }

        form input,
        form select,
        form textarea {
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 0.5em;
            margin-top: 0.5em;
            width: 100%;
        }

        form button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 0.5em;
            border: none;
            border-radius: 3px;
            margin-top: 1em;
        }

        a {
            display: block;
            text-align: center;
            margin: 1em;
        }
    </style>
</head>

<body>
<div id="header">
    <h1>Edit User</h1>
    <div>
        <a id="header-action" href="#">Back</a>
    </div>
</div>

<div id="content">
    <div id="errors"></div>
    <form id="edit-user-form">
        <input type="hidden" id="id" name="id">
        <label for="title" class="required">Title</label>
        <select id="title" name="title">
            <option value="">Select...</option>
            <option value="Mr">Mr</option>
            <option value="Mrs">Mrs</option>
            <option value="Miss">Miss</option>
            <option value="Ms">Ms</option>
            <option value="Dr">Dr</option>
        </select>
        <label for="first_name" class="required">First Name</label>
        <input type="text" id="first_name" name="first_name">
        <label for="surname" class="required">Surname</label>
        <input type="text" id="surname" name="surname">
        <label for="informal_name">Informal Name</label>
        <input type="text" id="informal_name" name="informal_name">
        <label for="address" class="required">Address</label>
        <textarea id="address" name="address"></textarea>
        <label for="town">Town</label>
        <input type="text" id="town" name="town">
        <label for="postcode" class="required">Postcode</label>
        <input type="text" id="postcode" name="postcode">
        <label for="ni_number">NI Number</label>
        <input type="text" id="ni_number" name="ni_number">
        <label for="date_of_birth">Date of Birth</label>
        <input type="date" id="date_of_birth" name="date_of_birth">
        <label for="mobile_tel">Mobile Telephone</label>
        <input type="text" id="mobile_tel" name="mobile_tel">
        <label for="home_tel">Home Telephone</label>
        <input type="text" id="home_tel" name="home_tel">
        <label for="other_tel">Other Telephone</label>
        <input type="text" id="other_tel" name="other_tel">
        <label for="personal_email">Personal Email</label>
        <input type="text" id="personal_email" name="personal_email">
        <label for="gender" class="required">Gender</label>
        <select id="gender" name="gender">
            <option value="">Select...</option>
            <option value="male">male</option>
            <option value="female">female</option>
            <option value="other">other</option>
        </select>
        <label for="initials">Initials</label>
        <input type="text" id="initials" name="initials">
        <label for="emergency_contact_name">Emergency Contact Name</label>
        <input type="text" id="emergency_contact_name" name="emergency_contact_name">
        <button type="submit">Update</button>
    </form>
</div>
</body>

<script>
    // Edit User Form Initialisation
    window.onload = async () => {
        const id = new URLSearchParams(window.location.search).get('id');
        if (!id || isNaN(id)) {
            document.getElementById('errors').innerHTML = 'Error: id parameter is missing or not a number';
            document.getElementById('edit-user-form').remove();
            return;
        }

        const response = await fetch(`/api/user?id=${id}`);
        if (!response.ok) {
            document.getElementById('errors').innerHTML = `Error fetching user with id ${id}`;
            document.getElementById('edit-user-form').remove();
            return;
        }

        const user = await response.json();
        document.getElementById('id').value = user.id;
        document.getElementById('title').value = user.title;
        document.getElementById('first_name').value = user.first_name;
        document.getElementById('surname').value = user.surname;
        document.getElementById('informal_name').value = user.informal_name || '';
        document.getElementById('gender').value = user.gender;
        document.getElementById('address').value = user.address;
        document.getElementById('town').value = user.town || '';
        document.getElementById('postcode').value = user.postcode;
        document.getElementById('ni_number').value = user.ni_number || '';
        document.getElementById('date_of_birth').value = user.date_of_birth;
        document.getElementById('mobile_tel').value = user.mobile_tel || '';
        document.getElementById('home_tel').value = user.home_tel || '';
        document.getElementById('other_tel').value = user.other_tel || '';
        document.getElementById('personal_email').value = user.personal_email || '';
        document.getElementById('initials').value = user.initials || '';
        document.getElementById('emergency_contact_name').value = user.emergency_contact_name || '';

        // Set header action
        document.getElementById('header-action').href = `/user?id=${user.id}`;
    };

    // Edit User Form Submission Handler
    document.getElementById('edit-user-form').addEventListener('submit', (event) => {
        event.preventDefault();

        // Serialise the form data and put to the update route
        const userData = JSON.stringify(Object.fromEntries(new FormData(event.target)));
        fetch('/api/update', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: userData
        })
            .then(response => {
                if (!response.ok) {
                    response.json().then(error => {
                        document.getElementById('errors').innerHTML = error.errors.map(error => error).join('<br>');
                    });
                    return window.scrollTo({top: 0, behavior: 'smooth'});
                }

                // Otherwise, we were successful so remove any errors and alert the user that the update was successful
                document.getElementById('errors').innerHTML = '';
                alert('Successfully updated user');
            })
            .catch(error => {
                document.getElementById('errors').innerHTML = error.message;
            });
    });
</script>
</html>