# Apartment Management Web Application

With the advent of the internet and E­commerce applications, Real estate field has embraced
both these technologies to leverage their service to a wider audience and market. Customers can
now view and book a place to rent from almost anywhere in the world. Websites like Airbnb
have helped normal homeowners to convert their homes and private space into rooms for
travelers. This Project is aimed at helping Leasing companies that predominantly serve people by
providing long term rental apartments to leverage their service by extending their apartments to
short­term rentals for travelers and business people and at the same time manage their long term
renters. Finding a long term renter is a big hassle, and in the process of finding long­term renters
leasing companies lose out on potential revenues when the apartments remain vacant for a short
period of time (1Week to 6 months). With this application that is being proposed the leasing
company can perform their day to day activities like managing their apartments better and also
provide additional services like short­term renting options based on the availability of the
apartments. The application aims to provide all the services required for the Management
company to operate as normal Leasing office and as additional feature provide an option to lease
an apartment for the short term.

### Scope of the Application
This Application will be primarily used to manage all the short term and long term rental
transactions for each of the apartment buildings managed under an Apartment Management
company. This application is aimed to cater to the needs of both the Management Staff and the
guest to manage apartments and apply for apartments respectively. The Management Staffs will
be able to use the application to update all the information regarding the apartment buildings
such as type of Apartments, Number of units, Facilities available for each apartment and
apartment booking status, The staffs would also be able to generate reports to find the
availability of any specific apartment and details of guests residing at their apartment building.
Staff’s would also be able to assign an available apartment to any new guest and on the other
hand guest would also have an option to register and apply for an apartment based on the
availability directly through the application. The guest would be able to manage their profile
information such as Name, Contact Number, Contact Email Id.

### SCHEMA
LIST OF TABLES AND THEIR FIELDS:
Below are the list of database tables and their fields that will be used for this website.
```
Apartment_Buildings:
* building_id
* building_short_name
* building_full_name
* building_description
* building_address
* building_manager
* building_phone

Guests
* guest_id
* guest_first_name
* guest_last_name
* guest_date_of_birth
* guest_gender

View_Unit_Status
* apt_id
* status_date
* availability
* apt_booking_id

Apartment_Bookings
* apt_booking_id
* apt_id
* guest_id
* booking_status_code
* booking_start_date
* booking_end_date

Apartments
* apt_id
* building_id
* apt_type_code
* apt_number
* bathroom_count
* bedroom_count
* room_count

Apartment_Facilitiies
* apt_id
* facility_code

Reference Tables
Apartment_Type
* apt_type_code
* apt_type_description

Booking_Status
* booking_status_code
* Booking_status_description

Ref_Apartment_Facilitiies
* facility_code
* facility_description

Member
* Id
* Username
* Password
* Email
```
### APPLICATION VIEWS:
As part of this project the following list of forms has been developed.

❖ Manage Apartment Information ­ Interface to add or update apartments under a apartment
building.

❖ List of Apartment Facilities ­ Screen to view the list of facilities for an apartment.
Ramesh Balasekaran,

❖ Apartment Availability ­ Manage all apartment booking information with interface to add,
edit and delete any bookings.

❖ Guest Directory ­ User interface to maintain guest information

❖ Login/Logout ­ Interface for the user to login to see all the information securely.
Reports

❖ List of Apartments that are under booked status

❖ List of Guests living in each apartment buildings

❖ List of Apartments based on the apartment type and facilities type.

