--
-- Tables
--
CREATE TABLE public."user" (
    id        SERIAL       NOT NULL
    ,salt     VARCHAR(8)   NOT NULL
    ,hashPass VARCHAR(64)  NOT NULL
    ,email    VARCHAR(255) NOT NULL
    ,name     VARCHAR(255)
);
ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);
ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_email_key UNIQUE (email);


CREATE TABLE public.vehicle (
    id         SERIAL       NOT NULL
    ,make      VARCHAR(255) NOT NULL
    ,model     VARCHAR(255) NOT NULL
    ,year      INTEGER      NOT NULL
    ,color     VARCHAR(255) NOT NULL
    ,vin       VARCHAR(255) NOT NULL
    ,preferred boolean      NOT NULL
    ,userid    INTEGER      NOT NULL
);
ALTER TABLE ONLY public.vehicle
    ADD CONSTRAINT vehicle_pkey PRIMARY KEY (id);
ALTER TABLE ONLY public.vehicle
    ADD CONSTRAINT vehicle_userid_fkey FOREIGN KEY (userid) REFERENCES public."user"(id);

CREATE TABLE public.category (
    id      SERIAL       NOT NULL
    ,name   VARCHAR(255) NOT NULL
    ,userid INTEGER      NOT NULL
);
ALTER TABLE ONLY public.category
    ADD CONSTRAINT category_pkey PRIMARY KEY (id);
ALTER TABLE ONLY public.category
    ADD CONSTRAINT category_userid_fkey FOREIGN KEY (userid) REFERENCES public."user"(id);

CREATE TABLE public.mileage (
    id            SERIAL  NOT NULL
    ,date         date    NOT NULL
    ,startMileage INTEGER NOT NULL
    ,endMileage   INTEGER NOT NULL
    ,vehicleid    INTEGER NOT NULL
    ,categoryid   INTEGER NOT NULL
);
ALTER TABLE ONLY public.mileage
    ADD CONSTRAINT mileage_pkey PRIMARY KEY (id);
ALTER TABLE ONLY public.mileage
    ADD CONSTRAINT mileage_categoryid_fkey FOREIGN KEY (categoryid) REFERENCES public.category(id);
ALTER TABLE ONLY public.mileage
    ADD CONSTRAINT mileage_vehicleid_fkey FOREIGN KEY (vehicleid) REFERENCES public.vehicle(id);

-- INSERT INTO public."user"
--   ( password, email, name)
--   VALUES
--   ('password', 'dcenatiempo@gmail.com', 'Devin');
-- INSERT INTO public."user"
--   (password, email, name)
--   VALUES
--   ('password', 'test@email.com', 'Test McTesterson');

-- INSERT INTO public.category
--   (name, userid)
--   VALUES
--   ('Business'
--   ,(SELECT id FROM public."user" WHERE email = 'dcenatiempo@gmail.com' ));
-- INSERT INTO public.category
--   (name, userid)
--   VALUES
--   ('Vacation'
--   ,(SELECT id FROM public."user" WHERE email = 'dcenatiempo@gmail.com' ));
-- INSERT INTO public.category
--   (name, userid)
--   VALUES
--   ('business'
--   ,(SELECT id FROM public."user" WHERE email = 'test@email.com' ));
-- INSERT INTO public.category
--   (name, userid)
--   VALUES
--   ('commute'
--   ,(SELECT id FROM public."user" WHERE email = 'test@email.com' ));
-- INSERT INTO public.category
--   (name, userid)
--   VALUES
--   ('shopping'
--   ,(SELECT id FROM public."user" WHERE email = 'test@email.com' ));

-- INSERT INTO public.vehicle
--   (userid, make, year, vin, preferred, model, color)
--   VALUES
--   ((SELECT id FROM public."user" WHERE email = 'dcenatiempo@gmail.com')
--   ,'Toyota', 2014, '123456789', true, 'Sierra', 'Gold');
-- INSERT INTO public.vehicle
--   (userid, make, year, vin, preferred, model, color)
--   VALUES
--   ((SELECT id FROM public."user" WHERE email = 'test@email.com' )
--   ,'Honda', 1999, '987654321', true, 'Civic', 'Black');

-- INSERT INTO public.mileage
--   (vehicleid, categoryid, date, startMileage, endMileage)
--   VALUES
--   (1
--   ,(SELECT id FROM public.category WHERE name = 'Business')
--   ,'2018-03-01', 32885, 32895);
-- INSERT INTO public.mileage
--   (vehicleid, categoryid, date, startMileage, endMileage)
--   VALUES
--   (1
--   ,(SELECT id FROM public.category WHERE name = 'Business')
--   ,'2018-03-02', 32895, 32909);
-- INSERT INTO public.mileage 
--   (vehicleid, categoryid, date, startMileage, endMileage)
--   VALUES
--   (1
--   ,(SELECT id FROM public.category WHERE name = 'Vacation')
--   ,'2018-03-03', 32909, 32965);
-- INSERT INTO public.mileage
--   (vehicleid, categoryid, date, startMileage, endMileage)
--   VALUES
--   (2
--   ,(SELECT id FROM public.category WHERE name = 'business' )
--   ,'2018-03-01', 115253, 115299);
-- INSERT INTO public.mileage
--   (vehicleid, categoryid, date, startMileage, endMileage)
--   VALUES
--   (2
--   ,(SELECT id FROM public.category WHERE name = 'shopping' )
--   ,'2018-03-01', 115299, 115333);