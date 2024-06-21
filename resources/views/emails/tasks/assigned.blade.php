<!-- resources/views/emails/tasks/assigned.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body>
    <h1>New Task Assigned to You</h1>
    <p>Title: {{ $task->title }}</p>
    <p>Description: {{ $task->description }}</p>
    <p>Deadline: {{ $task->deadline }}</p>
    <p>Assigned By: {{ $task->assigned_by }}</p>
    <p>Assigned To: {{ $employee->email }}</p>
</body>
</html>

