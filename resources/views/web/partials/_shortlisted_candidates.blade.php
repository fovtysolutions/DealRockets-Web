<h4>Shortlisted Candidates</h4>
<style>
    .subtableuno {
        display: none;
    }
</style>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Job Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($candidatesshortlisted as $index => $job)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $job['jobname'] }}</td>
                <td>
                    <button class="btn btn-sm btn-primary toggle-subtableuno">View Details</button>
                </td>
            </tr>
            <tr class="subtableuno">
                <td colspan="3">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($job['shortlisted'] as $index => $jobuno)
                                @if($jobuno)
                                <?php $data = \App\Utils\ChatManager::getjobapplierdetailsless($jobuno->id) ?>
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->phone }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-success">Edit</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    document.querySelectorAll('.toggle-subtableuno').forEach(button => {
        button.addEventListener('click', function () {
            const subtableuno = this.closest('tr').nextElementSibling;
            subtableuno.style.display = subtableuno.style.display === 'table-row' ? 'none' : 'table-row';
        });
    });
</script>