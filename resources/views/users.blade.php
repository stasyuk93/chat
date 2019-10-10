<div class="col-md-3">
    <div class="card" id="user-container">
        <div class="card-header">
            @if(auth()->user()->isAdmin())
                <div class="dropdown d-inline">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <button id="show-all-users" class="dropdown-item" type="button">All Users</button>
                        <button id="show-online-users" class="dropdown-item" type="button">Online Users</button>
                    </div>
                </div>
            @endif
            Online users: <span id="total-users"></span>
        </div>
        <div class="card-body">
            <ul id="list-users"></ul>
        </div>
    </div>
</div>
