<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UnseedTables');

		$this->call('GrilleTableSeeder');
		$this->command->info('Grilles Table Seeded!');

		$this->call('UserTableSeeder');
		$this->command->info('Users Table Seeded!');

		$this->call('HourTableSeeder');
		$this->command->info('Hours Table Seeded!');

		$this->call('CategoryTableSeeder');
		$this->command->info('Categories Table Seeded!');

		$this->call('ItemTableSeeder');
		$this->command->info('Items Table Seeded!');

		$this->call('AddonTableSeeder');
		$this->command->info('Addons Table Seeded!');

		$this->call('AddonItemTableSeeder');
		$this->command->info('Addon_items Table Seeded!');

		$this->call('InventoryTableSeeder');
		$this->command->info('Inventories Table Seeded!');
	}

}

// unseeds the table in reverse order of seeding
// to avoid foreignkey integrity violations
class UnseedTables extends Seeder
{
	public function run()
	{
		DB::table('inventories')->delete();
		DB::table('addon_item_orders')->delete();
		DB::table('item_orders')->delete();
		DB::table('orders')->delete();
		DB::table('addon_items')->delete();
		DB::table('addons')->delete();
		DB::table('items')->delete();
		DB::table('categories')->delete();
		DB::table('hours')->delete();
		DB::table('users')->delete();
		DB::table('grilles')->delete();
	}
}

class UserTableSeeder extends Seeder 
{
	public function run() 
	{
		User::create(array(	'id' => 1,
							'cs50_id' => 'random_string',
							'name' => 'Ian Boothby',
							'preferred_name' => 'Ian',
							'phone_number' => '6159183416',
							'email' => 'iboothby@college.harvard.edu',
							'hours_notification' => 0,
							'deals_notification' => 0,
							'privileges' => 'admin'
							));
		User::create(array(	'id' => 2,
							'cs50_id' => 'random_string',
							'name' => 'Nuseir Yassin',
							'preferred_name' => 'Nuesir',
							'phone_number' => '7734901404',
							'email' => 'nyassin@college.harvard.edu',
							'hours_notification' => 1,
							'deals_notification' => 1,
							'privileges' => 'admin'
							));
		User::create(array(	'id' => 3,
							'cs50_id' => 'random_string',
							'name' => 'Ryan Sandler',
							'preferred_name' => 'Ryan',
							'phone_number' => '9122578777',
							'email' => 'ryansandler@college.harvard.edu',
							'hours_notification' => 1,
							'deals_notification' => 0,
							'privileges' => 'admin'
							));
		User::create(array(	'id' => 4,
							'cs50_id' => 'random_string',
							'name' => 'Vladimir Bok',
							'preferred_name' => 'Vlad',
							'phone_number' => '6179391419',
							'email' => 'vladimirbok@college.harvard.edu',
							'hours_notification' => 0,
							'deals_notification' => 1,
							'privileges' => 'admin'
							));
		User::create(array(	'id' => 5,
							'cs50_id' => 'random_string',
							'name' => 'Daniel Broudy',
							'preferred_name' => 'Danny',
							'phone_number' => '2063847537',
							'email' => 'broudy@college.harvard.edu',
							'hours_notification' => 0,
							'deals_notification' => 0,
							'privileges' => 'user'
							));
		User::create(array(	'id' => 6,
							'cs50_id' => 'random_string',
							'name' => 'Jamie Law-Smith',
							'preferred_name' => 'Jamie',
							'phone_number' => '6172305842',
							'email' => 'jlaw-smith@college.harvard.edu',
							'hours_notification' => 0,
							'deals_notification' => 0,
							'privileges' => 'admin'
							));
		User::create(array(	'id' => 7,
							'cs50_id' => 'random_string',
							'name' => 'Peter Bang',
							'preferred_name' => 'Peter',
							'phone_number' => '5555555555',
							'email' => 'pbang@college.harvard.edu',
							'hours_notification' => 1,
							'deals_notification' => 1,
							'privileges' => 'manager',
							'grille_id' => 1
							));
	}
}

class GrilleTableSeeder extends Seeder 
{
	public function run()
	{
		Grille::create(array(	'id' => 1,
								'name' => 'Eliot Inferno',
								'phone_number' => '5555555555',
								'open_now' => 1
							));
	}
}

class HourTableSeeder extends Seeder
{
	public function run()
	{
		Hour::create(array(	'grille_id' => 1,
							'day_of_week' => 0,
							'open_time' => '22:30:00',
							'close_time' => '11:59:59'
							));
		Hour::create(array(	'grille_id' => 1,
							'day_of_week' => 1,
							'open_time' => '22:30:00',
							'close_time' => '11:59:59'
							));
		Hour::create(array(	'grille_id' => 1,
							'day_of_week' => 2,
							'open_time' => '22:30:00',
							'close_time' => '11:59:59'
							));
		Hour::create(array(	'grille_id' => 1,
							'day_of_week' => 3,
							'open_time' => '22:30:00',
							'close_time' => '11:59:59'
							));
		Hour::create(array(	'grille_id' => 1,
							'day_of_week' => 4,
							'open_time' => '23:30:00',
							'close_time' => '11:59:59'
							));
		Hour::create(array(	'grille_id' => 1,
							'day_of_week' => 5,
							'open_time' => '00:00:00',
							'close_time' => '02:29:59'
							));
		Hour::create(array(	'grille_id' => 1,
							'day_of_week' => 5,
							'open_time' => '23:30:00',
							'close_time' => '11:59:59'
							));
		Hour::create(array(	'grille_id' => 1,
							'day_of_week' => 6,
							'open_time' => '00:00:00',
							'close_time' => '02:29:59'
							));
		Hour::create(array(	'grille_id' => 1,
							'day_of_week' => 6,
							'open_time' => '22:30:00',
							'close_time' => '11:59:59'
							));
	}
}

class CategoryTableSeeder extends Seeder
{
	public function run ()
	{
		Category::create(array(	'id' => 1,
								'name' => 'Grilled Cheeses'));
		Category::create(array(	'id' => 2,
								'name' => 'Burgers'));		
		Category::create(array(	'id' => 3,
								'name' => 'Fries and Friends'));
		Category::create(array(	'id' => 4,
								'name' => 'Drinks and Desserts'));
	}
}

class ItemTableSeeder extends Seeder
{
	public function run ()
	{
		Item::create(array(	'id' => 1,
							'name' => 'The Standard',
							'price' => 3.00,
							'category_id' => 1,
							'grille_id' => 1,
							'description' => 'American cheese on your choice of bread',
							'available' => 1
							));
		Item::create(array(	'id' => 2,
							'name' => 'The Double Standard',
							'price' => 5.00,
							'category_id' => 1,
							'grille_id' => 1,
							'description' => 'Two Standards',
							'available' => 1
							));
		Item::create(array(	'id' => 3,
							'name' => 'The Sue Meltman',
							'price' => 3.50,
							'category_id' => 1,
							'grille_id' => 1,
							'description' => 'American and swiss on marbled or rye',
							'available' => 0
							));
		Item::create(array(	'id' => 4,
							'name' => 'The Doug Meltin',
							'price' => 3.50,
							'category_id' => 1,
							'grille_id' => 1,
							'description' => 'Extra-sharp yellow cheddar on your choice of bread',
							'available' => 1
							));
		Item::create(array(	'id' => 5,
							'name' => 'The Dean Evelyn Hammelt',
							'price' => 4.75,
							'category_id' => 1,
							'grille_id' => 1,
							'description' => 'American and jack cheese with bacon on your choice of bread',
							'available' => 1
							));
		Item::create(array(	'id' => 6,
							'name' => 'The CheeseBanger',
							'price' => 4.75,
							'category_id' => 1,
							'grille_id' => 1,
							'description' => 'Fontina and bacon on white bread',
							'available' => 1
							));		
		Item::create(array(	'id' => 7,
							'name' => 'Hamburger',
							'price' => 4.75,
							'category_id' => 2,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 8,
							'name' => 'Cheeseburger',
							'price' => 5.25,
							'category_id' => 2,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 9,
							'name' => 'Domus Domus',
							'price' => 6.00,
							'category_id' => 2,
							'grille_id' => 1,
							'description' => 'Double patties, double cheese',
							'available' => 1
							));
		Item::create(array(	'id' => 10,
							'name' => 'Shoestring Fries',
							'price' => 3.75,
							'category_id' => 3,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 11,
							'name' => 'Old Bay Fries',
							'price' => 4.00,
							'category_id' => 3,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 12,
							'name' => 'Onion Rings',
							'price' => 4.00,
							'category_id' => 3,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 13,
							'name' => 'Mozzarella Sticks',
							'price' => 4.00,
							'category_id' => 3,
							'grille_id' => 1,
							'description' => '',
							'available' => 0
							));
		Item::create(array(	'id' => 14,
							'name' => 'Sweet Potato Fries',
							'price' => 4.00,
							'category_id' => 3,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 15,
							'name' => 'Popcorn Chicken',
							'price' => 4.50,
							'category_id' => 3,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 16,
							'name' => 'Root Beer',
							'price' => 2.00,
							'category_id' => 4,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 17,
							'name' => 'Diet Root Beer',
							'price' => 2.00,
							'category_id' => 4,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 18,
							'name' => 'Root Beer Float',
							'price' => 3.75,
							'category_id' => 4,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 19,
							'name' => 'Ice Cream (2 scoops)',
							'price' => 2.00,
							'category_id' => 4,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 20,
							'name' => 'Vanille Shake',
							'price' => 3.50,
							'category_id' => 4,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 21,
							'name' => 'Oreo Shake',
							'price' => 4.00,
							'category_id' => 4,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
		Item::create(array(	'id' => 22,
							'name' => 'Mint Chocolate Chip Shake',
							'price' => 4.00,
							'category_id' => 4,
							'grille_id' => 1,
							'description' => '',
							'available' => 1
							));
	}
}

class AddonTableSeeder extends Seeder
{
	public function run ()
	{
		Addon::create(array(	'id' => 1,
								'name' => 'Bacon',
								'price' => 1.25,
								'description' => '',
								'grille_id' => 1,
								'available' => 1));
	}
}

class AddonItemTableSeeder extends Seeder
{
	public function run ()
	{
		AddonItem::create(array(	'item_id' => 7,
									'addon_id' => 1));
		AddonItem::create(array(	'item_id' => 8,
									'addon_id' => 1));
		AddonItem::create(array(	'item_id' => 9,
									'addon_id' => 1));
	}
}

class InventoryTableSeeder extends Seeder
{
	public function run ()
	{
		Inventory::create(array(	'id' => 1,
									'name' => 'Burgers',
									'description' => '53 patties per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 2,
									'name' => 'Sweet potato fries',
									'description' => '2.5lb bags',
									'quantity' => 6,
									'units' => 'bags'));
		Inventory::create(array(	'id' => 3,
									'name' => 'Root Beer',
									'description' => '24 bottles per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 4,
									'name' => 'Mozarella Sticks',
									'description' => '2lb per bag',
									'quantity' => 6,
									'units' => 'bags'));
		Inventory::create(array(	'id' => 5,
									'name' => 'Chicken Tenders',
									'description' => '5lb per bag',
									'quantity' => 2,
									'units' => 'bags'));
		Inventory::create(array(	'id' => 6,
									'name' => 'Hamburger buns',
									'description' => 'Six buns per bag',
									'quantity' => 6,
									'units' => '8 bags'));
		Inventory::create(array(	'id' => 7,
									'name' => 'Ketchup',
									'description' => '24 bottles per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 8,
									'name' => 'Diet Root beer',
									'description' => '24 per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 9,
									'name' => 'Marinara Sauce',
									'description' => '96 packets per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 10,
									'name' => 'Vanilla ice cream',
									'description' => '3-gallon tubs',
									'quantity' => 1,
									'units' => 'tubs'));
		Inventory::create(array(	'id' => 11,
									'name' => 'Mint chocolate chip ice cream',
									'description' => '3-gallon tubs',
									'quantity' => 1,
									'units' => 'tubs'));
		Inventory::create(array(	'id' => 12,
									'name' => 'Oreo ice cream',
									'description' => '3-gallon tubs',
									'quantity' => 1,
									'units' => 'tubs'));
		Inventory::create(array(	'id' => 13,
									'name' => 'Milk',
									'description' => '20 cartons per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 14,
									'name' => 'Napkins',
									'description' => '8 bags of 500 in a case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 15,
									'name' => 'Gloves',
									'description' => '4 boxes of 100 per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 16,
									'name' => 'Trays',
									'description' => '4 bags of 250 per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 17,
									'name' => '16oz cups',
									'description' => '696 per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 18,
									'name' => 'Souffle cups',
									'description' => '10 boxes of 250 per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 19,
									'name' => '12oz cups',
									'description' => '15 bags of 57 per case',
									'quantity' => 1,
									'units' => 'cases'));
		Inventory::create(array(	'id' => 20,
									'name' => 'American cheese',
									'description' => '160 slices per case',
									'quantity' => 1,
									'units' => 'cases'));
	}
}



