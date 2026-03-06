<x-mail::message>
# Nouvelle demande de contact

Une nouvelle demande de contact a été fait pour le bien <a href="{{ route('property.show', ['slug' => $property->getSlug(), 'property' => $property]) }}">{{ $property->title }}</a>

-**Prénom:** {{ $data['firstname'] }}<br/>
-**Nom:** {{ $data['lastname'] }}<br/>
-**Téléphpne:** {{ $data['phone'] }}<br/>
-**Email:** {{ $data['email'] }}<br/>

**Message :**<br/>
{{ $data['message'] }}


</x-mail::message>
