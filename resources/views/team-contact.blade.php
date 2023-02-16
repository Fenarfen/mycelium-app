<!DOCTYPE html>
<html lang= en>
    <head>
        <title>TeamContact</title>
    </head>
    <body>
        <h1>This is the contact information for {{$team->name}}</h1>
        @foreach ($contacts as $contact)
        <ul>
            <li>Handle: {{$contact->handle}}</li>
            <li>Website: {{$contact->website}}</li>
            <li>Contacted: {{$contact->contacted}}</li>
            <li>Engaged?: {{$contact->engaged}}</li>
        </ul>
        <br>
        @endforeach
    </body>
</html>