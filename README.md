# User Service

## Database

### Table users

- **id** bigint [pk]
- **first_name** varchar(150) [not null]
- **last_name** varchar(150) [not null]
- **username** varchar(110) [not null, unique]
- **password** varchar(100) [not null]
- **business_id** bigint [null] // if null is client else business
- **email** varchar(200) [not null]
- **email_verified_at** timestamp [null]
