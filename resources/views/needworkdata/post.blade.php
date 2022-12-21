<h1>Data Postingan</h1>

<table>
    <thead>
        <tr>
            <th>company_name</th>
            <th>company_logo</th>
            <th>company_location</th>
            <th>about_company</th>
            <th>company_gallery</th>
            <th>company_contact</th>
            <th>company_email</th>
            <th>poster</th>
            <th>job_type</th>
            <th>job_description</th>
            <th>skill_requirements</th>
            <th>salary_estimate</th>
            <th>advantages_of_join</th>
            <th>work_system</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vacancies as $vacancy)
        <tr>
            <td>{{$vacancy->company_name}}</td>
            <td><img src="{{$vacancy->company_logo}}" alt=""></td>
            <td>{{$vacancy->company_location}}</td>
            <td>{{$vacancy->about_company}}</td>
            <td><img src="{{$vacancy->company_gallery}}" alt=""></td>
            <td>{{$vacancy->company_contact}}</td>
            <td>{{$vacancy->company_email}}</td>
            <td>{{$vacancy->poster}}</td>
            <td>{{$vacancy->job_type}}</td>
            <td>{{$vacancy->job_description}}</td>
            <td>{{$vacancy->skill_requirements}}</td>
            <td>{{$vacancy->salary_estimate}}</td>
            <td>{{$vacancy->advantages_of_join}}</td>
            <td>{{$vacancy->work_system}}</td>
        </tr>
        
        @endforeach
    </tbody>
</table>

<a href="/needworkdata/newpost">Add Post</a>