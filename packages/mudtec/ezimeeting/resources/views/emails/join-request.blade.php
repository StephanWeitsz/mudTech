<!DOCTYPE html>
<html>
<head>
    <title>Join Request for Corporation</title>
</head>
<body>
    <h1>Join Request for Corporation</h1>
    <p>User {{ $userName }} has requested to join the corporation {{ $corporationName }}.</p>
    <p>Please review and approve the request.</p>
    <form action="{{ route('approveRequest', ['userid' => $requestId, 'corpid'=> $corpId]) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">Approve</button>
    </form>
    <form action="{{ route('rejectRequest', ['userid' => $requestId, 'corpid'=> $corpId]) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">Reject</button>
    </form>
</body>
</html>