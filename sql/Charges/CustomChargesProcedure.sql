
DELIMITER $$

CREATE PROCEDURE AddChargeCustom() 
DETERMINISTIC
BEGIN

		DECLARE bid, i, n, l, m, rid, sid, smid, flag, products, product int;
        DECLARE arrival, leaving datetime;

		SELECT COUNT(*) FROM ActiveCustomerLiveToRooms INTO n;

		select count(*) from Regions as a
						join ServicesAtSpecifiedRegions as b on b.idOtherRegions=a.idRegions
						join Services as c on c.idServices=b.idServices
						where c.idServices in (1,2,3)
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
			where c.idServices in (1,2,3)
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
					
				select (FLOOR( 1 + RAND( ) *products ))-1 into product;                
				
				select 
					idServiceMenu 
				from ServiceMenu 
					where idServices=sid
					order by idServiceMenu
					limit product, 1
					into smid;
				insert into ServiceCharge (BraceletId, idServiceMenu, Quantity, idRegions, CostAmount, Datetime, isPaid) 
                values (bid, smid, RandomHours(1,4), rid, 0, RandomDateBetween (arrival, leaving), ROUND(RAND()));

			-- select bid, smid, RandomHours(1,4), rid, 0, RandomDateBetween (arrival, leaving), ROUND(RAND()) ;
			
				set i = i+1;
			end while;
            set l = l + 1;
		end while;

END$$
DELIMITER ;

-- 
-- call AddChargeCustom();