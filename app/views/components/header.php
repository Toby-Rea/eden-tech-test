<style>
    @import url('https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap');

    body {
        font-family: 'Kumbh Sans', sans-serif;
    }

    #header {
        display: flex;
        justify-content: space-between;
        padding: 32px;
        background-color: #161b24;
        color: white;
        align-items: center;
    }

    #header-action {
        background-color: #1d6ad5;
        color: white;
        padding: 16px;
        text-decoration: none;
        font-weight: bold;
        border: none;
        border-radius: 3px;
        transition: opacity 0.1s ease-in-out;
    }

    #header-action:hover {
        opacity: 0.9;
    }

    #content {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 128px;
        margin-bottom: 128px;
    }

    #errors {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: red;
    }
</style>