<div class="col-md-4 col-sm-12 d-none d-md-block h-100" id="user-container">
    <div class="card h-100">
        <div class="card-header">
            <div class="h4">
                <span id="title-users"></span>
                <span id="total-users"></span>
            </div>
            @if($user->isAdmin())
            <div>
                <div class="dropdown d-inline">
                    <button class="btn btn-success fa fa-user-circle-o" type="button" id="user-option" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu" aria-labelledby="user-option">
                        <button id="show-all-users" class="dropdown-item" type="button">All Users</button>
                        <button id="show-online-users" class="dropdown-item" type="button">Online Users</button>
                    </div>
                </div>
                <div class="dropdown d-inline" id="admin-option">
                    <button class="btn btn-success fa fa-cog" type="button" id="admin-option" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu" aria-labelledby="admin-option">
                        <button id="ban-user" class="dropdown-item disabled" type="button">Ban</button>
                        <button id="mute-user" class="dropdown-item disabled" type="button">Mute</button>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="card-body h-100">
            <ul id="list-users" class="list-group list-group-flush h4" style="overflow-y: auto"></ul>
        </div>
    </div>
</div>
