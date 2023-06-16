<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hello world</title>
<style>
    .list-group {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
    border-radius: 0.25rem;
    }

    .list-group-item {
    position: relative;
    display: block;
    padding: 0.75rem 1.25rem;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .list-group-item:first-child {
    border-top-left-radius: inherit;
    border-top-right-radius: inherit;
    }

    .list-group-item:last-child {
    border-bottom-right-radius: inherit;
    border-bottom-left-radius: inherit;
    }

    .list-group-item + .list-group-item {
    border-top-width: 0;
    }

    .list-group-item-success {
    color: #155724;
    background-color: #c3e6cb;
    }

    .list-group-item-info {
    color: #0c5460;
    background-color: #bee5eb;
    }
</style>
</head>
<body>
    <ul class="list-group">
        <li class="list-group-item list-group-item-success">
            <p>Sender: <?= $sender ?></p>
        </li>
        <li class="list-group-item list-group-item-info">
            <p>Recipient: <?= $recipient ?></p>
        </li>
    </ul>
</body>
</html>