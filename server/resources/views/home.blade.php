<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <title>Chatos Task</title>
    <style>
        .web-hook-btn {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .message {
            display: flex;
            align-content: center;
            justify-content: center;
            font-size: 75px;
            color: #5b5aff;
        }


        .create-card {
            margin-top: 35px;
            padding: 15px;
            width: 450px;
        }

        .form-box {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

    </style>
</head>
<body>
<div class="message">
    @if(Session::has('message'))
        <p> {{ Session::get('message') }}</p>
    @endif
</div>

<div class="web-hook-btn">
    <a href="/webhook/create/telegram" type="button" class="btn btn-outline-success">Set telegram webhook</a>
    <a href="/webhook/create/trello" type="button" class="btn btn-outline-success">Set trello webhook</a>
</div>

<div class="form-box">
    <div class="create-card">
        <form action="/list" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label">List Name</label>
                <input type="text" name="name" class="form-control" aria-describedby="emailHelp">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="create-card">
        <form action="/card" method="post">
            @csrf
            <div>
                <select name="list" required class="form-select" aria-label="Default select example">
                    @foreach($lists as $list)
                        <option value="{{ $list['id'] }}">{{ $list['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Card Name</label>
                <input type="text" name="name" class="form-control" aria-describedby="emailHelp">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

</body>
</html>
