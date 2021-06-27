create view ServicesStatsLastSixMonths as
select 
	w.Description,
	w.RegionName,
	w.Profit,
    r.Preference
    from
(
    SELECT 
        q.Description AS Description,
        q.RegionName AS RegionName,
        SUM(w.TotalProfit) AS Profit
    FROM
        (
			(
				SELECT DISTINCT
					a.Description AS Description,
					e.RegionName AS RegionName
				FROM (
						
					mydb.Services a
					JOIN mydb.ServicesAtSpecifiedRegions b ON b.idServices = a.idServices
					JOIN mydb.Regions e ON e.idRegions = b.idOtherRegions
			)
		) q
		JOIN mydb.MenuStatsLastSixMonths w ON w.Service = q.Description
		)
		GROUP BY q.Description , q.RegionName
        )as w
        join

(
select count(*) / 
	(
		select count(*) from ServiceCharge
		where Datetime >= '2021-01-01 00:00:00'
        
	) as Preference, c.Description from ServiceCharge as a
join ServiceMenu as b on b.idServiceMenu=a.idServiceMenu
join Services as c on c.idServices=b.idServices
group by c.Description)as r on r.Description=w.Description

