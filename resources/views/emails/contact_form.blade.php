@component('mail::message')
# {{ $subject }}

- **Cliente:** {{ $name }}  
- **E-mail:** {{ $email }}  
- **Telefone:** {{ $phone }}  

**Mensagem:**   

{{ $message }}
   
   
---
**Mensagem enviada em:** {{ now()->format('d/m/Y H:n:s') }}
@endcomponent
