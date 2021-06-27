-- DELIMITER $$
-- CREATE FUNCTION RandomDateBetween (date_from DATETIME, date_to DATETIME) 
-- RETURNS DATETIME
-- BEGIN 
--   DECLARE result DATETIME;
--   SET result = (SELECT FROM_UNIXTIME(
--                       UNIX_TIMESTAMP(date_from) + FLOOR(
--                           RAND() * (
--                               UNIX_TIMESTAMP(date_to) - UNIX_TIMESTAMP(date_from) + 1
--                           )
--                       )
--                ));
--   RETURN (result);
-- END$$
-- DELIMITER ;
-- 
-- DELIMITER $$
-- CREATE FUNCTION RandomHours (start int, end int) 
-- RETURNS int
-- BEGIN 
--   DECLARE result int;
--   SET result = (SELECT (FLOOR( start + RAND( ) *(end-start+1) )));
--   RETURN (result);
-- END$$
-- DELIMITER ;
--  

DELIMITER $$

CREATE PROCEDURE AddCharge() 
DETERMINISTIC
BEGIN

		DECLARE bid, i, n, l, m, rid, sid, smid, flag, products, product int;
        DECLARE arrival, leaving datetime;

		SELECT COUNT(*) FROM ActiveCustomerLiveToRooms INTO n;

		select count(*) from Regions as a
						join ServicesAtSpecifiedRegions as b on b.idOtherRegions=a.idRegions
						join Services as c on c.idServices=b.idServices
						where c.idServices in (4,5,6)
                        into m;

        select 0 into @counter;
        set l = 0;
        while l < m do
			SET i=0;

			select 
				a.idRegions,
                c.idServices
			from Regions as a
			join ServicesAtSpecifiedRegions as b on b.idOtherRegions=a.idRegions
			join Services as c on c.idServices=b.idServices
			where c.idServices in (4,5,6)
            order by a.idRegions,c.idServices
			limit l,1 into rid, sid;
            

            select 
				count(*)
            from ServiceMenu 
				where idServices=sid
				into products;
			
            
			loop_1: WHILE i<n DO
			
				SELECT BraceletId, ArrivalDatetime, LeavingDatetime
				FROM ActiveCustomerLiveToRooms
					LIMIT i,1 into bid, arrival, leaving;
					
				select idServices
				from SubscriptionToServices  
					where BraceletId=bid and idServices=sid
                    into flag;
                    
				if (flag is null ) then
					SET i = i + 1;
					iterate loop_1;
                        
				end if;
                
				select (FLOOR( 1 + RAND( ) *products ))-1 into product;                
				
				select 
					idServiceMenu 
				from ServiceMenu 
					where idServices=sid
					order by idServiceMenu
					limit product, 1
					into smid;
				insert into ServiceCharge (BraceletId, idServiceMenu, Quantity, idRegions, CostAmount, Datetime, isPaid) 
                values (bid, smid, RandomHours(1,4), rid, 0, RandomDateBetween (arrival, leaving), 0);

			-- select bid, smid, RandomHours(1,4), rid, 0, RandomDateBetween (arrival, leaving), 0 ;
			
				set i = i+1;
			end while;
            set l = l + 1;
		end while;

END$$
DELIMITER ;


call AddCharge();