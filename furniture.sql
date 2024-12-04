drop database furniture;

create database if not exists furniture;
use furniture;

create table users ( 
	user_id int not null auto_increment primary key,
	fName varchar(50),
	lName varchar(50),
	email varchar(255),
	username varchar(50),
	pw varchar(50),
    userType varchar(25)
);

create table items (
	item_id int not null auto_increment primary key,
	item_name varchar(255),
	category varchar(255),
	color varchar(50),
	image_path varchar(255),
	price decimal(6,2),
	description varchar(255),
	amount_current int
);

create table cart (
	cart_id int not null auto_increment primary key,
	item_id int not null, 
	user_id int not null,
	foreign key (item_id) references items(item_id),
	foreign key (user_id) references users(user_id)
);

create table layaway (
	user_id int not null,
	item_id int not null,
	foreign key (item_id) references items(item_id),
	foreign key (user_id) references users(user_id)
);

INSERT INTO items (item_name, category, color, image_path, price, description, amount_current) 
VALUES
('Light Wash Leather 3 Seater', 'sittings', 'brown', 'couch1.jpg', 479.99, 'A comfortable modern sofa.', 2),
('Queen Anne Inspired Cloth 2 Seater', 'sittings', 'white', 'couch2.jpg', 599.99, 'Stylish leather ottoman.', 7),
('Arched Lounger', 'sittings', 'white', 'couch3.jpg', 449.99, 'Relaxing recliner chair.', 4),
('Modern Leather Section', 'sittings', 'brown', 'couch4.jpg', 1299.99, 'Compact loveseat for two.', 3),
('Pop Velvet 3 Seater', 'sittings', 'green', 'couch5.jpg', 899.99, 'Spacious sectional sofa.', 1);

INSERT INTO items (item_name, category, color, image_path, price, description, amount_current)
VALUES
('Metal Stylistic Open Dining Chair', 'chairs', 'black', 'chair1.jpg', 79.99, 'Elegant wooden dining chair.', 20),
('Metal Low Sweedish Chair', 'chairs', 'white', 'chair2.jpg', 75.99, 'Ergonomic office chair.', 25),
('Velvet Silver Accentended Chair', 'chairs', 'blue', 'chair3.jpg', 55.99, 'Traditional rocking chair.', 12),
('Wooden Classic Dining Chair', 'chairs', 'white', 'chair4.jpg', 49.99, 'Decorative accent chair.', 10),
('Laid-Back Plastic Contemporary Chair', 'chairs', 'white', 'chair5.jpg', 69.99, 'Portable folding chair.', 30);

INSERT INTO items (item_name, category, color, image_path, price, description, amount_current)
VALUES
('Bell Floor Lamp', 'lighting', 'yellow', 'lighting1.jpg', 59.99, 'Modern table lamp.', 15),
('Chandelier', 'lighting', 'yellow', 'lighting2.jpg', 249.99, 'Elegant ceiling light.', 10),
('Glass Table Lamp', 'lighting', 'red', 'lighting3.jpg', 64.99, 'Stylish floor lamp.', 8),
('Ceramic Flower Table Lamp', 'lighting', 'pink', 'lighting4.jpg', 79.99, 'Classic wall sconce.', 12),
('Desk Light', 'lighting', 'black', 'lighting5.jpg', 19.99, 'Industrial pendant light.', 6);

INSERT INTO items (item_name, category, color, image_path, price, description, amount_current)
VALUES
('Metal Stool Nightstand', 'tables', 'black', 'table1.jpg', 67.99, 'Spacious dining table.', 4),
('Plastic Drawer Nightstand', 'tables', 'white', 'table2.jpg', 79.99, 'Modern coffee table.', 10),
('Wooden Entry Table', 'tables', 'brown', 'table3.jpg', 199.99, 'Compact side table.', 15),
('Wooden Dining Table', 'tables', 'black', 'table4.jpg', 449.99, 'Elegant console table.', 5),
('Plastic Round Dining Table', 'tables', 'white', 'table5.jpg', 119.99, 'Wooden study desk.', 7);

INSERT INTO items (item_name, category, color, image_path, price, description, amount_current)
VALUES
('Street Merchant Painting', 'decorations', 'yellow', 'decoration1.jpg', 79.99, 'Abstract wall art.', 20),
('Scenic Greenery Painting', 'decorations', 'yellow', 'decoration2.jpg', 129.99, 'Ceramic decorative vase.', 25),
('Smoked Glass Vase  Set', 'decorations', 'blue', 'decoration3.jpg', 49.99, 'Comfortable throw pillow.', 30),
('Bulb Vase', 'decorations', 'brown', 'decoration4.jpg', 14.99, 'Classic photo frame.', 18),
('Cricle Cut-Out Vase', 'decorations', 'white', 'decoration5.jpg', 59.99, 'Decorative candle holder.', 12);

#creating an admin user 
insert into users (fname, lname, email, username, pw, userType) 
values("DB","Admin","ITAdmin@example.com","IT_Admin","password1","Admin");
#ensure that this default password is changed



# Role Creation
create role DB_ADMIN;
create role EMPLOYEE;
create role CUSTOMER;

# Assigning roles and permissions
grant select, insert, update on users to DB_ADMIN;
grant select, insert, update on items to DB_ADMIN;
grant select, insert, update on cart to DB_ADMIN;
grant select, insert, update on layaway to DB_ADMIN;

grant select, update on users to EMPLOYEE;
grant select, update on items to EMPLOYEE;
grant select, update on cart to EMPLOYEE;
grant select, insert, update on layaway to EMPLOYEE;

grant select, update on users to CUSTOMER;
grant select on items to CUSTOMER;
grant select, insert, update on cart to CUSTOMER;
grant select, insert, update on layaway to CUSTOMER;

#view creating
#admin user
create view view_admin_user 
	as select  user_id, fname, lname, email, username, userType 
    from users ;

#admin items
create view view_admin_items 
	as select item_name, category, color, image_path, price, 
    description, amount_current  
    from items ;

#admin cart    
create view view_admin_cart
	as select cart_id, item_id, user_id from cart ;

#admin layaway    
create view view_admin_layaway 
	as select user_id, item_id, item_name from layaway;
    
#employee users
create view view_employee_users 
	as select user_id, fname, lname, email, username 
    from users
    where user_type = (select user_type from users);

#employee items
create view view_employee_items 
	as select item_name, item_id, category, color, price,
    description, amount_current  
    from items ;

#employee cart    
create view view_employee_cart
	as select cart_id, item_id, 
   #item_name, 
    user_id
    from cart ;

#employee layaway    
create view view_employee_layaway 
	as select user_id, item_id 
    #,item_name 
    from layaway;
    
#create view view_customer_users
#	as select user_id, fname, lname, email, username from users
#		where user_id = (select current_user_id from users);

#customer items
create view view_customer_items 
	as select item_name, item_id, category, color, price,
    description  
    from items 
    where amount_current > 1;

#customer cart    
create view view_customer_cart
	as select cart_id, item_id 
    #,item_name 
    from cart 
    where cart.user_id = (select user_id from users);

#customer layaway    
create view view_customer_layaway 
	as select item_id 
    #,item_name 
    from layaway
    where layaway.user_id = (select user_id from users);

# view granting
grant select on view_admin_users to DB_ADMIN;
grant select on view_admin_items to DB_ADMIN;
grant select on view_admin_cart to DB_ADMIN;
grant select on view_admin_layaway to DB_ADMIN;

grant select on view_employee_users to EMPLOYEE;
grant select on view_employee_items to EMPLOYEE;
grant select on view_employee_cart to EMPLOYEE;
grant select on view_employee_layaway to EMPLOYEE;

grant select on view_customer_users to CUSTOMER;
grant select on view_customer_items to CUSTOMER;
grant select on view_customer_cart to CUSTOMER;
grant select on view_customer_layaway to CUSTOMER;
