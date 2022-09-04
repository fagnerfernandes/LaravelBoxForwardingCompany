<li>
    <a href="{{ route('customer.addresses.index') }}">
        <div class="parent-icon"><i class='bx bx-map' ></i>
        </div>
        <div class="menu-title">Meus endereços</div>
    </a>
</li>
{{-- <li class="menu-label">UI Elements</li> --}}
<li>
    <a href="{{ route('customer.packages.index') }}">
        <div class="parent-icon"><i class='bx bx-package'></i>
        </div>
        <div class="menu-title">Pacotes recebidos</div>
    </a>
</li>
<li>
    <a href="{{ route('customer.shippings.index') }}">
        <div class="parent-icon"><i class='bx bx-send'></i>
        </div>
        <div class="menu-title">Meus envios</div>
    </a>
</li>
<li>
    <a href="{{ route('customer.premium_shoppings.index') }}">
        <div class="parent-icon"><i class='bx bx-carousel'></i>
        </div>
        <div class="menu-title">Serviços Premium</div>
    </a>
</li>
<li>
    <a href="{{ route('customer.items.available') }}">
        <div class="parent-icon"><i class='bx bx-collection'></i>
        </div>
        <div class="menu-title">Meu estoque</div>
    </a>
</li>
<li>
    <a href="{{ route('customer.credits.index') }}">
        <div class="parent-icon"><i class='bx bx-wallet'></i>
        </div>
        <div class="menu-title">Créditos</div>
    </a>
</li>
<li>
    <a href="{{ route('customer.assisted-purchases.index') }}">
        <div class="parent-icon"><i class='bx bx-tv'></i>
        </div>
        <div class="menu-title">Compras assistidas</div>
    </a>
</li>

<li>
    <a href="{{ route('customer.orders.index') }}">
        <div class="parent-icon"><i class='bx bx-shopping-bag'></i>
        </div>
        <div class="menu-title">Pedidos</div>
    </a>
</li>

<li>
    <a href="{{ route('customer.reports.statistics.index') }}">
        <div class="parent-icon"><i class='bx bxs-report'></i>
        </div>
        <div class="menu-title">Relatório Estatístico</div>
    </a>
</li>

<li>
    <a href="{{ route('customer.faqs.index') }}">
        <div class="parent-icon"><i class='bx bx-chat'></i>
        </div>
        <div class="menu-title">FAQ</div>
    </a>
</li>
<li>
    <a href="{{ route('customer.shops.index') }}">
        <div class="parent-icon"><i class='bx bx-store'></i>
        </div>
        <div class="menu-title">Onde Comprar</div>
    </a>
</li>
<li>
    <a href="{{ route('shipping.calc') }}" target="_blank">
        <div class="parent-icon"><i class='bx bx-calculator'></i>
        </div>
        <div class="menu-title">Calculadora de Frete</div>
    </a>
</li>
<li>
    <a href="{{ route('contact_form.show') }}">
        <div class="parent-icon"><i class='bx bx-mail-send'></i>
        </div>
        <div class="menu-title">Entre em Contato</div>
    </a>
</li>