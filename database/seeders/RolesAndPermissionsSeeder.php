<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'view attendances']);
        Permission::create(['name' => 'mark attendances']);
        Permission::create(['name' => 'edit attendances']);
        Permission::create(['name' => 'delete attendances']);

        Permission::create(['name' => 'view leave_requests']);
        Permission::create(['name' => 'create leave_requests']);
        Permission::create(['name' => 'edit leave_requests']);
        Permission::create(['name' => 'delete leave_requests']);

        Permission::create(['name' => 'view suppliers']);
        Permission::create(['name' => 'create suppliers']);
        Permission::create(['name' => 'edit suppliers']);
        Permission::create(['name' => 'delete suppliers']);

        Permission::create(['name' => 'view supplier_bills']);
        Permission::create(['name' => 'create supplier_bills']);
        Permission::create(['name' => 'edit supplier_bills']);
        Permission::create(['name' => 'delete supplier_bills']);

        Permission::create(['name' => 'view sites']);
        Permission::create(['name' => 'create sites']);
        Permission::create(['name' => 'edit sites']);
        Permission::create(['name' => 'delete sites']);

        Permission::create(['name' => 'view site_material']);
        Permission::create(['name' => 'create site_material']);
        Permission::create(['name' => 'edit site_material']);
        Permission::create(['name' => 'delete site_material']);

        Permission::create(['name' => 'view money_indent']);
        Permission::create(['name' => 'create money_indent']);
        Permission::create(['name' => 'edit money_indent']);
        Permission::create(['name' => 'delete money_indent']);

        Permission::create(['name' => 'view site_expense']);
        Permission::create(['name' => 'create site_expense']);
        Permission::create(['name' => 'edit site_expense']);
        Permission::create(['name' => 'delete site_expense']);

        Permission::create(['name' => 'view boq']);
        Permission::create(['name' => 'create boq']);
        Permission::create(['name' => 'edit boq']);
        Permission::create(['name' => 'delete boq']);

        Permission::create(['name' => 'view subarea']);
        Permission::create(['name' => 'create subarea']);
        Permission::create(['name' => 'edit subarea']);
        Permission::create(['name' => 'delete subarea']);

        Permission::create(['name' => 'view assign_sardar']);
        Permission::create(['name' => 'create assign_sardar']);
        Permission::create(['name' => 'edit assign_sardar']);
        Permission::create(['name' => 'delete assign_sardar']);

        Permission::create(['name' => 'view materials']);
        Permission::create(['name' => 'create materials']);
        Permission::create(['name' => 'edit materials']);
        Permission::create(['name' => 'delete materials']);

        Permission::create(['name' => 'view material_at_site']);
        Permission::create(['name' => 'create material_at_site']);
        Permission::create(['name' => 'edit material_at_site']);
        Permission::create(['name' => 'delete material_at_site']);

        Permission::create(['name' => 'view material_requests']);
        Permission::create(['name' => 'create material_requests']);
        Permission::create(['name' => 'edit material_requests']);
        Permission::create(['name' => 'delete material_requests']);

        Permission::create(['name' => 'view vehicle_managements']);
        Permission::create(['name' => 'create vehicle_managements']);
        Permission::create(['name' => 'edit vehicle_managements']);
        Permission::create(['name' => 'delete vehicle_managements']);

        Permission::create(['name' => 'view vehicle_types']);
        Permission::create(['name' => 'create vehicle_types']);
        Permission::create(['name' => 'edit vehicle_types']);
        Permission::create(['name' => 'delete vehicle_types']);

        Permission::create(['name' => 'view vehicle_parts']);
        Permission::create(['name' => 'create vehicle_parts']);
        Permission::create(['name' => 'edit vehicle_parts']);
        Permission::create(['name' => 'delete vehicle_parts']);

        Permission::create(['name' => 'view manage_vehicles_trip']);
        Permission::create(['name' => 'create manage_vehicles_trip']);
        Permission::create(['name' => 'edit manage_vehicles_trip']);
        Permission::create(['name' => 'delete manage_vehicles_trip']);

        Permission::create(['name' => 'view vehicle_part_requests']);
        Permission::create(['name' => 'create vehicle_part_requests']);
        Permission::create(['name' => 'edit vehicle_part_requests']);
        Permission::create(['name' => 'delete vehicle_part_requests']);

        Permission::create(['name' => 'view headof_ac']);
        Permission::create(['name' => 'create headof_ac']);
        Permission::create(['name' => 'edit headof_ac']);
        Permission::create(['name' => 'delete headof_ac']);

        Permission::create(['name' => 'view bank_accounts']);
        Permission::create(['name' => 'create bank_accounts']);
        Permission::create(['name' => 'edit bank_accounts']);
        Permission::create(['name' => 'delete bank_accounts']);

        Permission::create(['name' => 'view cash_accounts']);
        Permission::create(['name' => 'create cash_accounts']);
        Permission::create(['name' => 'edit cash_accounts']);
        Permission::create(['name' => 'delete cash_accounts']);

        Permission::create(['name' => 'view payment_managements']);
        Permission::create(['name' => 'create payment_managements']);
        Permission::create(['name' => 'edit payment_managements']);
        Permission::create(['name' => 'delete payment_managements']);

        Permission::create(['name' => 'view supplier_ledger']);
        Permission::create(['name' => 'create supplier_ledger']);
        Permission::create(['name' => 'edit supplier_ledger']);
        Permission::create(['name' => 'delete supplier_ledger']);

        Permission::create(['name' => 'view issue_material']);
        Permission::create(['name' => 'create issue_material']);
        Permission::create(['name' => 'edit issue_material']);
        Permission::create(['name' => 'delete issue_material']);

        Permission::create(['name' => 'view daily_progresses']);
        Permission::create(['name' => 'create daily_progresses']);
        Permission::create(['name' => 'edit daily_progresses']);
        Permission::create(['name' => 'delete daily_progresses']);

        Permission::create(['name' => 'view siteorders']);
        Permission::create(['name' => 'create siteorders']);
        Permission::create(['name' => 'edit siteorders']);
        Permission::create(['name' => 'delete siteorders']);

        Permission::create(['name' => 'view receive_documents']);
        Permission::create(['name' => 'create receive_documents']);
        Permission::create(['name' => 'edit receive_documents']);
        Permission::create(['name' => 'delete receive_documents']);

        Permission::create(['name' => 'view dispatch_documents']);
        Permission::create(['name' => 'create dispatch_documents']);
        Permission::create(['name' => 'edit dispatch_documents']);
        Permission::create(['name' => 'delete dispatch_documents']);

        Permission::create(['name' => 'view tasks']);
        Permission::create(['name' => 'create tasks']);
        Permission::create(['name' => 'edit tasks']);
        Permission::create(['name' => 'delete tasks']);

        // Create roles and assign existing permissions
        $role = Role::create(['name' => 'owner']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'site_manager']);
        $role->givePermissionTo(['view site', 'view tasks', 'edit tasks', 'view material_requests', 'edit material_requests', 'delete material_requests']);
    }
}
