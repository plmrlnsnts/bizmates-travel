# 🇯🇵 Bizmates - Travel and Weather App

You should have a **PHP 8+** and **Node 16+** installed in your machine to run the application. Clone the repository then install the dependencies using composer and npm. I will send via email the credentials for OpenWeather and Foursquare APIs.

```bash
git clone git@github.com:plmrlnsnts/bizmates-travel.git
cd bizmates-travel
cp .env.example .env
composer install && php artisan key:generate
npm install && npm run dev
php artisan serve
```

## 🥞 Tech Stack

 We are using Inertia.js and its Vue 3 adapter, paired with Tailwind CSS to build the frontend application.

 We are using Laravel for backend and server side rendering. We have a caching strategy to avoid exhausting the API quota of OpenWeather and Foursquare APIS.

## 🚀 App Experience

Here's a gif to showcase the overall experience of the application.

![Demo GIF](./docs/demo.gif)

- 🤖 This is a single page application so every visit is snappy.
- 💨 We cache all requests from third-party APIs so it's blazing fast after your first visit.
- ⌨️ Keyboard accessibility is taken into consideration. Meaning you can easily navigate throughout the page using your keyboard.
- ✨ All the UI design are custom. The icons are from [Heroicons](https://heroicons.com/]).

## 📀 Part 2: SQL Exam

Write a query to display the ff columns:
- `ID` format: T + 11 digits of `trn_teacher.id` with leading zeros like *T00000088424*,
- `Nickname`,
- `Status`, and
- `Roles`, like *Trainer/Assessor/Staff*

```sql
select
    concat('T', lpad(t.id, 11, '0')) as 'ID',
    t.nickname as 'Nickname',
    case t.status
        when 0 then 'Discontinued'
        when 1 then 'Active'
        when 2 then 'Deactivated'
    end as 'Status',
    group_concat(
        case tr.role
            when 1 then 'Trainer'
            when 2 then 'Assessor'
            when 3 then 'Staff'
        end
        separator '/'
    ) as 'Roles'
from trn_teacher t
join trn_teacher_role tr on tr.teacher_id = t.id
group by t.id
```

Write a query to display the ff columns:
- ID (from teacher.id),
- Nickname, Open (total open slots from trn_teacher_time_table),
- Reserved (total reserved slots from trn_teacher_time_table),
- Taught (total taught from trn_evaluation) and
- NoShow (total no_show from trn_evaluation) using all tables above.

Should show only those who are active (`trn_teacher.status` = 1 or 2) and those who have both *Trainer* and *Assessor* role.

```sql
select
    t.id as 'ID',
    t.nickname as 'Nickname',
    (select count(*) from trn_time_table tt where tt.teacher_id = t.id and tt.status = 1) as 'Open',
    (select count(*) from trn_time_table tt where tt.teacher_id = t.id and tt.status = 3) as 'Reserved',
    (select count(*) from trn_evaluation te where te.teacher_id = t.id and te.result = 1) as 'Taught',
    (select count(*) from trn_evaluation te where te.teacher_id = t.id and te.result = 2) as 'No Show'
from trn_teacher t
where t.status in (1, 2)
and exists (
    select 1 from trn_teacher_role tr
    where tr.teacher_id = t.id
    and tr.role in (1, 2)
)
```
