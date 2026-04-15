<!DOCTYPE html>
<html>
<head>
    <title>Test Update Status</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Test Update Status AJAX</h1>
    
    <form id="testForm">
        <label>ID Proposal:</label>
        <select name="id">
            <option value="2">ID 2 - Disetujui</option>
            <option value="6">ID 6 - Disetujui</option>
            <option value="7">ID 7 - belum disetujui</option>
            <option value="8">ID 8 - Ditolak</option>
        </select>
        
        <label>Status:</label>
        <select name="status">
            <option value="Disetujui">Disetujui</option>
            <option value="Ditolak">Ditolak</option>
            <option value="belum disetujui">belum disetujui</option>
        </select>
        
        <button type="submit">Update Status</button>
    </form>
    
    <div id="result"></div>
    
    <script>
    $('#testForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'pengajuan/updatestatus',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log('Response:', response);
                $('#result').html('<h3>Success:</h3><pre>' + JSON.stringify(response, null, 2) + '</pre>');
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                $('#result').html('<h3>Error:</h3><pre>' + xhr.responseText + '</pre>');
            }
        });
    });
    </script>
</body>
</html>
