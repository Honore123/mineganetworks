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
      <li class="nav-item {{setActive('customer-pruchase-order')}} {{setActive('customer-pruchase-order/*')}}">
        <a class="nav-link" href="{{route('customer-po.index')}}">
          <i class="ti-notepad menu-icon"></i>
          <span class="menu-title">Customer's P.O</span>
        </a>
      </li>
      <li class="nav-item {{setActive('purchase-order')}} {{setActive('purchase-order/*')}}">
        <a class="nav-link" data-toggle="collapse" href="#purchase-order-drop" aria-expanded="false" aria-controls="purchase-order-drop">
          <i class="ti-notepad menu-icon"></i>
          <span class="menu-title">Contractor's P.O</span>
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
          <i class="ti-envelope menu-icon"></i>
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
      <li class="nav-item {{setActive('projects')}}{{setActive('issues')}} {{setActive('projects/*')}}{{setActive('issues/*')}}">
        <a class="nav-link" data-toggle="collapse" href="#project-risks-drop" aria-expanded="false" aria-controls="project-risks-drop">
          <i class="ti-notepad menu-icon"></i>
          <span class="menu-title">Issue log</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{showCollapse('projects')}} {{showCollapse('projects/*')}} {{showCollapse('issues')}} {{showCollapse('issues/*')}}" id="project-risks-drop">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item {{setActive('projects')}} {{setActive('projects/*')}}"> <a class="nav-link" href="{{route('projects-risks.index')}}">Projects</a></li>
            <li class="nav-item {{setActive('issues')}} {{setActive('issues/*')}}"> <a class="nav-link" href="{{route('risk.index')}}">Issues</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{setActive('documents')}} {{setActive('documents/*')}}">
        <a class="nav-link" href="{{route('document.index')}}">
          <i class="ti-notepad menu-icon"></i>
          <span class="menu-title">Documents</span>
        </a>
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
      <li class="nav-item {{setActive('riggers')}} {{setActive('riggers/*')}}">
        <a class="nav-link" href="{{route('riggers.index')}}">
          <i class="ti-user menu-icon"></i>
          <span class="menu-title">Riggers</span>
        </a>
      </li>
      <li class="nav-item {{setActive('drivers')}} {{setActive('drivers/*')}}">
        <a class="nav-link" href="{{route('drivers.index')}}">
          <i class="ti-car menu-icon"></i>
          <span class="menu-title">Drivers</span>
        </a>
      </li>
      <li class="nav-item {{setActive('users')}} {{setActive('users/*')}}">
        <a class="nav-link" href="{{route('users.index')}}">
          <i class="ti-user menu-icon"></i>
          <span class="menu-title">Users</span>
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
            <li class="nav-item {{setActive('settings/logs')}} {{setActive('settings/logs/*')}}"> <a class="nav-link" href="{{route('logs.index')}}">Logs</a></li>
            <li class="nav-item {{setActive('settings/password')}} {{setActive('settings/password/*')}}"> <a class="nav-link" href="{{route('change.password')}}">Change Password</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>