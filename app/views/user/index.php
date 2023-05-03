<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <?php include(__DIR__ . '/../components/header.php') ?>
    <style>
        #users {
            list-style: none;
            display: grid;
            width: 60%;
            grid-template-columns: repeat(3, 1fr);
            text-align: center;
            grid-row-gap: 48px;
        }

        #users li a {
            color: #1d6ad5;
            font-weight: bold;
        }
    </style>
</head>

<body>
<div id="header">
    <h1>Users</h1>
    <a id="header-action" href="/create">Create a new user</a>
</div>

<div id="content">
    <div id="errors"></div>
    <ul id="users"></ul>
</div>
</body>

<script>
    // This code loads the users list from the api and displays them in a list. For each user, a
    // link to the user page is created and added to the list.
    window.onload = async () => {
        try {
            const response = await fetch('/api/users');
            const users = await response.json();
            users.forEach(user => {
                const li = document.createElement("li");
                const anchor = document.createElement("a");
                anchor.textContent = `${user.title} ${user.first_name} ${user.surname}`;
                anchor.href = `/user?id=${user.id}`;
                li.appendChild(anchor);
                document.getElementById("users").appendChild(li);
            });
        } catch (err) {
            const error = await response.json();
            document.getElementById('errors').innerHTML = error.message;
        }
    };
</script>
</html>