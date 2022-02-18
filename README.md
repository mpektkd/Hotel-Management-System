# HotelManagementSystem-MySQL-PHP 
## ASDF Palace (Hotel)
I designed a DB for a hotel and a control-UI for the staff. 

Further down, the notation "(some text)" refers to the correspondnig table-entity in the database.

A)The hotel contains 4 floors, 25 rooms("mydb.Room") per floor, and groundfloor where there are multiple services("mydb.Services")
and regions("mydb.Regions"). 

Namely, there are the following services-regions:

  "Drink at Bar" at 4 Bars,
  "Food and Drink at Restaurant" at 3 Restaurants,
  "Use of Meeting Room" at 5 Meeting Rooms,
  "Training at Gym" at 4 Gyms,
  "Rest at Sauna" at 6 Saunas,
  "Hair and Body Care at Hair Salon" at 3 Hair Salons. 

Each service, takes place at these above Specified Regions("mydb.ServicesAtSpecifiedRegions").

B)One Customer("mydb.Customer") can have lots of bookings(mydb.ActiveCustomerLiveToRooms) and each time has booked one room and has an NFCID, that allows to 
move to ther regions and make charges("mydb.ServiceCharges"). 

C)For the safety of customers due to Covid-19, the hotel allocates tracking system, that keeps track the action of each customer.

Namely, passing an entry("mydbEntriesToRegions") from a region to another is stored ("mydb.PassingEntries") and is shown at the UI ("mydb.CustomerVisitRegions").

Each customer has access("mydb.ApprovedEntries") only at the corridor of her/his room's floor and at ground-floor's Bars, Restaurants,
Hair Salons("mydb.NotSubscribed"). In order to obtain access to Meeting Rooms, Gyms, Suanas he/she has to be subscribed to these services. 




# Installation

1. git clone https://github.com/mpektkd/asdf.git
2. Install xampp or lamp, corresponding to your OS and make a server
3. Change the credentials in the DBConnection.php, to fit to yours
3. Run "asdf/sql/dump.sql" for creating and filling database
4. localhost/asdf is the url for the front-end
