<section class="card">
  <div class="card-body">
    {{-- Componente de gerenciamento de chaves API fornecido pela biblioteca --}}
    <x-api-keys::manager :owner="$user" owner-alias="user" />
  </div>
</section>
