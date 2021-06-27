
DELIMITER $$

CREATE PROCEDURE PassEntries(
	id1 int,
    id2 int,
    l int
) 
DETERMINISTIC
BEGIN
		DECLARE bid ,room, mycorridor, e_mycorridor, myelevator, e_myelevator, groundcorridor, 
        e_groundcorridor, servregion, e_servregion, visit_interval, ground_corridor_2, e_ground_corridor_2,
        myelevator_2, e_myelevator_2, mycorridor_2, e_mycorridor_2, e_room_2, rand_day, rand_time, i, n, j, m  int;
        
        DECLARE arrival, leaving, start_date, end_date,
        from_room_date, from_mycorridor_date, from_myelevator_date, 
        from_groundcorridor_date, from_servregion_date, 
        from_groundcorridor_date_2, from_myelevator_date_2, 
        from_mycorridor_date_2 datetime;
        
        DECLARE Reg nvarchar(50);
        
		SELECT COUNT(*) FROM ActiveCustomerLiveToRooms
			where BraceletId between id1 and id2
			INTO n;
            
        SELECT 6 INTO m;
		SET j=0;
        select 0 into @counter;
        
		select ArrivalDatetime, LeavingDatetime 
		from ActiveCustomerLiveToRooms
			where BraceletId=id1
				into arrival, leaving;
						
		-- Define visit interval 
		select 6 into visit_interval;

		-- Define start/end date
        
        -- start tomorrow, 10:00 PM
		select (date_add(date_sub(date_add(arrival, interval 1 day), interval hour(arrival) hour), interval 10 hour)) into start_date;
		select (date_sub(leaving, interval hour(leaving)+visit_interval hour)) into end_date;
					
	
		WHILE j<m DO
				
                # Generate random datetime
				select FLOOR(rand()* (day(end_date)-day(start_date)) + day(start_date)) into rand_day;
				select FLOOR(rand()* (20-9) + 9) into rand_time;

				select date_format(
					concat(year(arrival),"-",month(arrival),"-", 
							convert(rand_day, char)," ", 	
							convert(rand_time, char),":00:00"
							), '%Y-%m-%d %H:%i:%s' 
				) into from_room_date;
				
				-- select date_add(date_add(start_date, interval 3 hour),interval 30 minute) into from_room_date;
                
                SELECT RegionName 
				FROM 
				(
					select distinct RegionName from Regions 
						where RegionName in ('Bar', 'Restaurant','Hair Salon','Gym','Sauna','Meeting Room')
                        order by RegionName
				)as a
				
				LIMIT j,1 into Reg;
				select Reg;			
				
                SET i=0;
                
			loop_1: WHILE i<n DO  
            
				SET servregion = NULL;
                
				set from_room_date = date_add(date_add(from_room_date, interval (FLOOR( 1 + RAND( ) *60 )) minute ),interval (FLOOR( 1 + RAND( ) *60 )) second);
                
				SELECT BraceletId 
                FROM ActiveCustomerLiveToRooms
					where BraceletId between id1 and id2
					LIMIT i,1 into bid;

				select idRoom 
					from ActiveCustomerLiveToRooms
						where BraceletId=bid into room;

				select idRegionsTo, idEntriesToRegions
				from EntriesToRegions 
					where idRegionsFrom = room 
						into mycorridor, e_mycorridor;

				select idRegionsTo, idEntriesToRegions 
				from EntriesToRegions 
					where idRegionsFrom=mycorridor
						and Description_EntryPoint like "%Elavator%"
							into myelevator, e_myelevator;

				select idRegionsTo, idEntriesToRegions 
				from EntriesToRegions 
					where idRegionsFrom=myelevator 
						and Description_EntryPoint like "%Corridor%" 
						and idRegionsTo between 101 and 104
							into groundcorridor, e_groundcorridor;
										
				select idRegionsTo, idEntriesToRegions 
				from EntriesToRegions 
				where idRegionsFrom=groundcorridor
					and Description_EntryPoint like CONCAT('%', Reg, '%') -- it has to be changed
					and idEntriesToRegions in (
												select idEntriesToRegions 
												from ApprovedEntries
													where BraceletId=bid
												)limit l,1
						into servregion, e_servregion;
								select servregion;
				if (servregion is null ) then
					SET i = i + 1;
					iterate loop_1;
                        
				end if;
	

				select date_add(from_room_date, interval 3 minute) into from_mycorridor_date;
				select date_add(from_mycorridor_date, interval 1 minute) into from_myelevator_date;
				select date_add(from_myelevator_date, interval 5 minute) into from_groundcorridor_date;


				# Insert Data for Entry
				insert into PassingEntry (BraceletId, idEntriesToRegions, Datetime, Approvement)
				select bid, e_mycorridor, from_room_date, 1 
				union
				select bid, e_myelevator, from_mycorridor_date, 1 
				union
				select bid, e_groundcorridor, from_myelevator_date, 1 
				union
				select bid, e_servregion, from_groundcorridor_date, 1 ;


				# Leave the service region

				select idRegionsTo, idEntriesToRegions
				from EntriesToRegions 
					where idRegionsFrom = servregion
					and (Description_EntryPoint like "%Corridor%")
					into ground_corridor_2, e_ground_corridor_2;

				select idRegionsTo, idEntriesToRegions
				from EntriesToRegions 
					where idRegionsFrom = ground_corridor_2 
					and idEntriesToRegions in 
									(select idEntriesToRegions 
										from ApprovedEntries
											where BraceletId=bid
										)
					and Description_EntryPoint like "%Elavator%" -- perhaps to another region
					into myelevator_2, e_myelevator_2;

				select idRegionsTo, idEntriesToRegions
				from EntriesToRegions 
					where idRegionsFrom = myelevator_2 
					and idEntriesToRegions in 
									(select idEntriesToRegions 
										from ApprovedEntries
											where BraceletId=bid
										)
					and idRegionsTo not in (101, 102, 103, 104)
					into mycorridor_2, e_mycorridor_2;
					
				select idEntriesToRegions
				from EntriesToRegions 
					where idRegionsFrom = mycorridor_2 
					and idRegionsTo = room
					into e_room_2;

				select date_add(from_groundcorridor_date, interval 2 hour) into from_servregion_date;
				select date_add(from_servregion_date, interval 3 minute) into from_groundcorridor_date_2;
				select date_add(from_groundcorridor_date_2, interval 1 minute) into from_myelevator_date_2;
				select date_add(from_myelevator_date_2, interval 5 minute) into from_mycorridor_date_2;

				# Insert Data for Exit
				insert into PassingEntry (BraceletId, idEntriesToRegions, Datetime, Approvement)
				select bid, e_ground_corridor_2, from_servregion_date, 1 
				union
				select bid, e_myelevator_2, from_groundcorridor_date_2, 1 
				union
				select bid, e_mycorridor_2, from_myelevator_date_2, 1 
				union
				select bid, e_room_2, from_mycorridor_date_2, 1 ;
                
				SET i = i + 1;
                set @counter := @counter+1;
                
			END WHILE loop_1;
            
			SET j = j + 1;
            
		END WHILE;
        select @counter;
		END$$
DELIMITER ;

call PassEntries(6, 10, 0);

