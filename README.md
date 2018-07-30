Task
======

1. Application should have form with field where user can put valid url (validation should be done by direct call of the provided url and check HTTP response code).

2. Application should generate short url. Example: http://domaincom/cedwdsfl

3. It should be possible to enter desired short url (another field).

4. Application should validate if requested short url is not in use yet.

5. Application should store original and short url pair in DB. User than can share short url with other users and once they try to access short url they should be redirected to

original url.


Extra Credit
============

1. Application should have configuration file. logging system.

2. Application should remove origin-short url pair from DB on the 15th day after its creation.

3. Application should count amount of short url usage. Application should have API for short url creations.

4. GitHub repo should contain a descriptive commits history




s_u_v1
======

A Symfony project created on January 25, 2018, 9:06 pm.
