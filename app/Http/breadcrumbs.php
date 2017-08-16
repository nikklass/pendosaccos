<?php

use App\Deposit;
use App\Group;
use App\Loan;
use App\Permission;
use App\Repayment;
use App\Role;
use App\SmsOutbox;
use App\User;
use App\Withdrawal;

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});


/******** SMS OUTBOX ROUTES ********/

// Home > SMS outbox
Breadcrumbs::register('smsoutbox', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Sms Outbox', route('smsoutbox.index'));
});

// Home > SMS outbox > Create New SMS
Breadcrumbs::register('smsoutbox.create', function($breadcrumbs)
{
    $breadcrumbs->parent('smsoutbox');
    $breadcrumbs->push('Create New SMS', route('smsoutbox.create'));
});

// Home > SMS outbox > Show SMS
Breadcrumbs::register('smsoutbox.show', function($breadcrumbs, $id)
{
    $smsoutbox = SmsOutbox::findOrFail($id);
    $breadcrumbs->parent('smsoutbox');
    $breadcrumbs->push('Showing Sms Outbox Id - ' . $smsoutbox->id, route('smsoutbox.show', $smsoutbox->id));
});

/******** SMS OUTBOX ROUTES ********/


/******** GROUPS ROUTES ********/

// Home > Groups
Breadcrumbs::register('groups', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Groups', route('groups.index'));
});

// Home > Groups > Create New Group
Breadcrumbs::register('groups.create', function($breadcrumbs)
{
    $breadcrumbs->parent('groups');
    $breadcrumbs->push('Create New Group', route('groups.create'));
});

// Home > Groups > Show Group
Breadcrumbs::register('groups.show', function($breadcrumbs, $id)
{
    $group = Group::findOrFail($id);
    $breadcrumbs->parent('groups');
    $breadcrumbs->push('Showing Group - ' . $group->name, route('groups.show', $group->id));
});

// Home > Groups > Edit Group
Breadcrumbs::register('groups.edit', function($breadcrumbs, $id)
{
    $group = Group::findOrFail($id);
    $breadcrumbs->parent('groups');
    $breadcrumbs->push('Edit Group - ' . $group->name, route('groups.edit', $group->id));
});

/******** END GROUPS ROUTES ********/



/******** WITHDRAWALS ROUTES ********/

// Home > withdrawals
Breadcrumbs::register('withdrawals', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('withdrawals', route('withdrawals.index'));
});

// Home > withdrawals > Create New withdrawal
Breadcrumbs::register('withdrawals.create', function($breadcrumbs)
{
    $breadcrumbs->parent('withdrawals');
    $breadcrumbs->push('Create New Withdrawal', route('withdrawals.create'));
});

// Home > withdrawals > Show withdrawal
Breadcrumbs::register('withdrawals.show', function($breadcrumbs, $id)
{
    $withdrawal = Withdrawal::findOrFail($id);
    $breadcrumbs->parent('withdrawals');
    $breadcrumbs->push('Displaying Withdrawal Id - ' . $withdrawal->id, route('withdrawals.show', $withdrawal->id));
});

// Home > withdrawals > Edit withdrawal
Breadcrumbs::register('withdrawals.edit', function($breadcrumbs, $id)
{
    $withdrawal = Withdrawal::findOrFail($id);
    $breadcrumbs->parent('withdrawals');
    $breadcrumbs->push('Edit Withdrawal Id - ' . $withdrawal->id, route('withdrawals.edit', $withdrawal->id));
});

/******** END WITHDRAWAL ROUTES ********/




/******** DEPOSIT ROUTES ********/

// Home > deposits
Breadcrumbs::register('deposits', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('deposits', route('deposits.index'));
});

// Home > deposits > Create New deposit
Breadcrumbs::register('deposits.create', function($breadcrumbs)
{
    $breadcrumbs->parent('deposits');
    $breadcrumbs->push('Create New Deposit', route('deposits.create'));
});

// Home > deposits > Show deposit
Breadcrumbs::register('deposits.show', function($breadcrumbs, $id)
{
    $deposit = Deposit::findOrFail($id);
    $breadcrumbs->parent('deposits');
    $breadcrumbs->push('Showing Deposit Id - ' . $deposit->id, route('deposits.show', $deposit->id));
});

// Home > deposits > Edit deposit
Breadcrumbs::register('deposits.edit', function($breadcrumbs, $id)
{
    $deposit = Deposit::findOrFail($id);
    $breadcrumbs->parent('deposits');
    $breadcrumbs->push('Edit Deposit Id - ' . $deposit->id, route('deposits.edit', $deposit->id));
});

/******** END DEPOSIT ROUTES ********/



/******** REPAYMENTS ROUTES ********/

// Home > repayments
Breadcrumbs::register('repayments', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('repayments', route('repayments.index'));
});

// Home > repayments > Create New Repayment
Breadcrumbs::register('repayments.create', function($breadcrumbs)
{
    $breadcrumbs->parent('repayments');
    $breadcrumbs->push('Create Loan Repayment', route('repayments.create'));
});

// Home > repayments > Show Repayment
Breadcrumbs::register('repayments.show', function($breadcrumbs, $id)
{
    $repayment = Repayment::findOrFail($id);
    $breadcrumbs->parent('repayments');
    $breadcrumbs->push('Showing Loan Repayment - ' . $repayment->id, route('repayments.show', $repayment->id));
});

// Home > repayments > Edit Repayment
Breadcrumbs::register('repayments.edit', function($breadcrumbs, $id)
{
    $repayment = Repayment::findOrFail($id);
    $breadcrumbs->parent('repayments');
    $breadcrumbs->push('Edit Loan Repayment - ' . $repayment->id, route('repayments.edit', $repayment->id));
});

/******** END REPAYMENTS ROUTES ********/


/******** LOANS ROUTES ********/

// Home > loans
Breadcrumbs::register('loans', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('loans', route('loans.index'));
});

// Home > loans > Create New Loan
Breadcrumbs::register('loans.create', function($breadcrumbs)
{
    $breadcrumbs->parent('loans');
    $breadcrumbs->push('Create Loan', route('loans.create'));
});

// Home > loans > Show Loan
Breadcrumbs::register('loans.show', function($breadcrumbs, $id)
{
    $loan = Loan::findOrFail($id);
    $breadcrumbs->parent('loans');
    $breadcrumbs->push('Showing Loan - ' . $loan->id, route('loans.show', $loan->id));
});

// Home > loans > Edit Loan
Breadcrumbs::register('loans.edit', function($breadcrumbs, $id)
{
    $loan = Loan::findOrFail($id);
    $breadcrumbs->parent('loans');
    $breadcrumbs->push('Edit Loan - ' . $loan->id, route('loans.edit', $loan->id));
});

/******** END LOANS ROUTES ********/



/******** PERMISSIONS ROUTES ********/

// Home > Permissions
Breadcrumbs::register('permissions', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Permissions', route('permissions.index'));
});

// Home > Permissions > Create New Permission
Breadcrumbs::register('permissions.create', function($breadcrumbs)
{
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push('Create New Permission', route('permissions.create'));
});

// Home > Permissions > Show Permission
Breadcrumbs::register('permissions.show', function($breadcrumbs, $id)
{
    $permission = Permission::findOrFail($id);
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push('Showing Permission - ' . $permission->display_name, route('permissions.show', $permission->id));
});

// Home > Permissions > Edit Permission
Breadcrumbs::register('permissions.edit', function($breadcrumbs, $id)
{
    $permission = Permission::findOrFail($id);
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push('Edit Permission - ' . $permission->display_name, route('permissions.edit', $permission->id));
});

/******** END PERMISSIONS ROUTES ********/


/******** ROLES ROUTES ********/

// Home > Roles
Breadcrumbs::register('roles', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('roles', route('roles.index'));
});

// Home > Roles > Create New Role
Breadcrumbs::register('roles.create', function($breadcrumbs)
{
    $breadcrumbs->parent('roles');
    $breadcrumbs->push('Create New Role', route('roles.create'));
});

// Home > Roles > Show Role
Breadcrumbs::register('roles.show', function($breadcrumbs, $id)
{
    $role = Role::findOrFail($id);
    $breadcrumbs->parent('roles');
    $breadcrumbs->push('Displaying Role - ' . $role->display_name, route('roles.show', $role->id));
});

// Home > Roles > Edit Role
Breadcrumbs::register('roles.edit', function($breadcrumbs, $id)
{
    $role = Role::findOrFail($id);
    $breadcrumbs->parent('roles');
    $breadcrumbs->push('Edit Role - ' . $role->display_name, route('roles.edit', $role->id));
});

/******** END ROLES ROUTES ********/



/******** USERS ROUTES ********/

// Home > Users
Breadcrumbs::register('users', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Users', route('users.index'));
});

// Home > Users > Create New User
Breadcrumbs::register('users.create', function($breadcrumbs)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Create New User', route('users.create'));
});

// Home > Users > Create Bulk User Accounts
Breadcrumbs::register('bulk-users.create', function($breadcrumbs)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Create Bulk User Accounts', route('bulk-users.create'));
});

// Home > Users > Show User
Breadcrumbs::register('users.show', function($breadcrumbs, $id)
{
    $user = User::findOrFail($id);
    $full_names = $user->first_name . ' ' . $user->last_name;
    $breadcrumbs->parent('users');
    $breadcrumbs->push("Displaying User - " . $full_names, route('users.show', $user->id));
});

// Home > Users > Edit User
Breadcrumbs::register('users.edit', function($breadcrumbs, $id)
{
    $user = User::findOrFail($id);
    $full_names = $user->first_name . ' ' . $user->last_name;
    $breadcrumbs->parent('users');
    $breadcrumbs->push("Edit User - " . $full_names, route('users.edit', $user->id));
});


/******** END USERS ROUTES ********/

