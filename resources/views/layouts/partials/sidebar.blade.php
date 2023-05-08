<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item {{setActive('/')}}">
        <a class="nav-link" href="{{route('dashboard')}}">
          <i class="ti-dashboard menu-icon"></i>
          <span class="menu-title"> Dashboard</span>
        </a>
      </li>
      <li class="nav-item {{setActive('products')}} {{setActive('products/*')}}">
        <a class="nav-link" href="{{route('product.index')}}">
          <i class="ti-shopping-cart-full menu-icon"></i>
          <span class="menu-title">Products</span>
        </a>
      </li>
      <li class="nav-item {{setActive('quotation')}} {{setActive('quotation/*')}}">
        <a class="nav-link" data-toggle="collapse" href="#quotation-drop" aria-expanded="false" aria-controls="quotation-drop">
          <i class="ti-pencil-alt menu-icon"></i>
          <span class="menu-title">Quotations</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{showCollapse('quotation')}} {{showCollapse('quotation/*')}}" id="quotation-drop">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item {{setActive('quotation/add')}}"> <a class="nav-link" href="{{route('quotation.add')}}">New Quotation</a></li>
            <li class="nav-item {{setActive('quotation')}}"> <a class="nav-link" href="{{route('quotation.index')}}">Manage Quotations</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{setActive('purchase-order')}} {{setActive('purchase-order/*')}}">
        <a class="nav-link" data-toggle="collapse" href="#purchase-order-drop" aria-expanded="false" aria-controls="purchase-order-drop">
          <i class="ti-pencil-alt menu-icon"></i>
          <span class="menu-title">Purchase Order</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{showCollapse('purchase-order')}} {{showCollapse('purchase-order/*')}}" id="purchase-order-drop">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item {{setActive('purchase-order/add')}}"> <a class="nav-link" href="{{route('purchase-order.add')}}">New P.O</a></li>
            <li class="nav-item {{setActive('purchase-order')}}"> <a class="nav-link" href="{{route('purchase-order.index')}}">Manage P.O</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{setActive('invoice')}} {{setActive('invoice/*')}}">
        <a class="nav-link" data-toggle="collapse" href="#invoice-drop" aria-expanded="false" aria-controls="invoice-drop">
          <i class="ti-pencil-alt menu-icon"></i>
          <span class="menu-title">Invoices</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{showCollapse('invoice')}} {{showCollapse('invoice/*')}}" id="invoice-drop">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item "> <a class="nav-link" href="{{route('invoice.add')}}">New Invoice</a></li>
            <li class="nav-item "> <a class="nav-link" href="{{route('invoice.index')}}">Manage Invoices</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{setActive('customers')}} {{setActive('customers/*')}}">
        <a class="nav-link" href="{{route('customer.index')}}">
          <i class="ti-user menu-icon"></i>
          <span class="menu-title">Customers</span>
        </a>
      </li>
      <li class="nav-item {{setActive('vendors')}} {{setActive('vendors/*')}}">
        <a class="nav-link" href="{{route('vendor.index')}}">
          <i class="ti-user menu-icon"></i>
          <span class="menu-title">Vendors</span>
        </a>
      </li>
      <li class="nav-item {{setActive('settings')}} {{setActive('settings/*')}}">
        <a class="nav-link" data-toggle="collapse" href="#settings-drop" aria-expanded="false" aria-controls="ui-basic">
          <i class="ti-settings menu-icon"></i>
          <span class="menu-title">Settings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="settings-drop">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item {{setActive('settings/categories')}} {{setActive('settings/categories/*')}}"> <a class="nav-link" href="{{route('category.index')}}">Categories</a></li>
            <li class="nav-item {{setActive('settings/subcategories')}} {{setActive('settings/subcategories/*')}}"> <a class="nav-link" href="{{route('subcategory.index')}}">Sub-Categories</a></li>
            <li class="nav-item {{setActive('settings/measurement_unit')}} {{setActive('settings/measurement_unit/*')}}"> <a class="nav-link" href="{{route('measurement.index')}}">Measurement Unit</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>