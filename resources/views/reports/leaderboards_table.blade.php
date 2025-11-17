<!DOCTYPE html>
<html>
<head>
    <title>Leaderboards Report</title>
    <style>
        body { font-family: 'Arial', sans-serif; }
        h1, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        #patient {display: grid; grid-column: 1fr 1fr ; justify-content: space-between; align-items: center; gap: 1rem; padding: 1rem;}
        #patient h4 span {font-weight: 400;}
        #date, #time {min-width: 100px;}
        #app {min-width: 120px;}
    </style>
</head>
<body>
    <h1>Text-Twist Game <span></span></h1>
    <h3>Leaderboards Report</h3>
   
    <div id="patient">
        <h4>Date Report: <span> {{$currentDate}}</span> </h4>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Student Number</th>
                <th>Section</th>
                <th>Highscore</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaderboards as $user)
            <tr>
            
                <td id="app">{{$user->firstname}} {{$user->middlename}} {{$user->lastname}}</td>
                <td >{{$user->user->username}}</td>
                <td >{{$user->student_number}}</td>
                <td >{{$user->year}}</td>
                <td >{{$user->highscore}} pts</td>
  
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>