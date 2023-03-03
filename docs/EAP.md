# EAP


## A7: Web Resources Specification

### 7.1 Overview


| Module | Web resources | 
| -------- | -------- | 
| M01: Authentication and User Profiles| Web resources associated with user authetication and profile management. Includes login, logout, registration, credential recovery, view and edit personal profile.|
| M02: Posts, comments and public timeline| Web resources associated with creating, editing and deleting posts and it's associated comments. Also includes the public timeline of the main page.|
| M03: Groups | Web resources associated with creating, moderating, editing, deleting groups. This groups will have its own comments and posts.|
| M04: Private Messages and Relations| Web resourses associated with sending and receiving private messages between users. All users can create, edit and delete their messages. This will change on the relation between both users. In other words, if they are friends, don't know each other or if one of them is blocked.|
| M05: User administration and Static Pages| Web resources associated with user management, specially: create, delete and update users, create, delete and update all posts/comments on website. Web resources with static content are associated with this module.|

### 7.2 Permissions

|Simplified Name|Name|Description|
| -------- | -------- | -------- | 
| __PUB__ | Public | Users withou any privileges|
| __USR__ | User | Authenticated users|
| __OWN__ | Owner| User that owns something like posts, profile,etc|
| __ADM__ | Administrator | User that can control other users profiles and posts|

### 7.3 OpenAPI Specification

<a href=""></a>

```
openapi: 3.0.0

info:
 version: '1.0'
 title: 'LBAW ProteinGram Web API'
 description: 'Web Resources Specification (A7) for ProteinGram'

servers:
- url: http://lbaw.fe.up.pt
  description: Production server

externalDocs:
 description: Find more info here.

tags:
 - name: 'M01: Authentication and User Profiles'
 - name: 'M02: Posts, comments and public timeline'
 - name: 'M03: Groups'
 - name: 'M04: Private Messages and Relations'
 - name: 'M05: User administration and Static Pages'

paths:
 /login:
   get:
     operationId: R101
     summary: 'R101: Login Form'
     description: 'Provide login form. Access: PUB'
     tags:
       - 'M01: Authentication and User Profiles'
     responses:
       '200':
         description: 'Ok. Show Log-in UI'
   post:
     operationId: R102
     summary: 'R102: Login Action'
     description: 'Processes the login form submission. Access: PUB'
     tags:
       - 'M01: Authentication and User Profiles'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               email:          # <!--- form field name
                 type: string
               password:    # <!--- form field name
                 type: string
             required:
                  - email
                  - password
   

     responses:
       '302':
         description: 'Redirect after processing the login credentials.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful authentication. Redirect to public timeline.'
                 value: '/'
               302Error:
                 description: 'Failed authentication. Redirect to login form.'
                 value: '/login'

 /logout:

   post:
     operationId: R103
     summary: 'R103: Logout Action'
     description: 'Logout the current authenticated user. Access: USR, ADM'
     tags:
       - 'M01: Authentication and User Profiles'
     responses:
       '302':
         description: 'Redirect after processing logout.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful logout. Redirect to public timeline.'
                 value: '/'

 /register:
   get:
     operationId: R104
     summary: 'R104: Register Form'
     description: 'Provide new user registration form. Access: PUB'
     tags:
       - 'M01: Authentication and User Profiles'
     responses:
       '200':
         description: 'Ok. Show Sign-Up UI'

   post:
     operationId: R105
     summary: 'R105: Register Action'
     description: 'Processes the new user registration form submission. Access: PUB'
     tags:
       - 'M01: Authentication and User Profiles'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               name:
                 type: string
               email:
                 type: string
               password:
                  type: string
               confirm_password:
                  type: string
             required:
                                    -name
                                    - email
                                   - password
                                   -confirm_password

     responses:
       '302':
         description: 'Redirect after processing the new user information.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful authentication. Redirect to public timeline.'
                 value: '/'
               302Failure:
                 description: 'Failed authentication. Redirect to register form.'
                 value: '/register'

 /users/{id}:
   get:
     operationId: R106
     summary: 'R106: View user profile'
     description: 'Show the individual user profile. Access: PUB, USR, OWN, ADM'
     tags:
       - 'M01: Authentication and User Profiles'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show User Profile UI'
         
   post:
     operationId: R202
     summary: 'R202: Delete post'
     description: 'Delete a post from the profile. Access: OWN, ADM'
     tags:
       - 'M02: Posts, comments and public timeline'

     requestBody:
  

     responses:
       '302':
         description: 'Redirect after deleting post.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successfull deletion'
                 value: '/users/{id}'
               302Failure:
                 description: 'Failed deletion'
                 value: '/users/{id}'
         
     
         
 /users/edit/{id}:
   get:
     operationId: R107
     summary: 'R107: Edit user profile'
     description: 'Show the edit profile form. Access: OWN, ADM'
     tags:
       - 'M01: Authentication and User Profiles'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show Edit Profile Form UI'
         
   post:
     operationId: R108
     summary: 'R105: Update Action'
     description: 'Retrieves information and updates the profile. Access: OWN, ADM'
     tags:
       - 'M01: Authentication and User Profiles'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               name:
                 type: string
               image:
                 type: string
               bio:
                  type: string
               is_private:
                  type: string
               is_admin:
                  type: string
             required:
                                    -name
                                    - bio
                                   - is_private
                                   - is_admin

     responses:
       '302':
         description: 'Redirect after the update.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful update. Redirect to user page.'
                 value: '/users/{id}'
               302Failure:
                 description: 'Failed update. Redirect to user page.'
                 value: '/users/{id}'
 
 /users/delete/{id}:
   get:
     operationId: R109
     summary: 'R109: Delete user profile confirmation'
     description: 'Show the delete profile confirmation form. Access: OWN, ADM'
     tags:
       - 'M01: Authentication and User Profiles'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show Delete Profile Confirmation Form UI'
         
   post:
     operationId: R110
     summary: 'R110: Delete Action'
     description: 'Deletes the user from website. Access: OWN, ADM'
     tags:
       - 'M01: Authentication and User Profiles'

     requestBody:

     responses:
       '302':
         description: 'Redirect after the deletion.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful delete. Redirect to mainTimeline.'
                 value: '/'
               302Failure:
                 description: 'Failed delete. Redirect to user page.'
                 value: '/users/{id}'
 
 /:
   get:
     operationId: R201
     summary: 'R201: Main Page'
     description: 'Show the public timeline. Access: PUB,USR,ADM'
     tags:
       - 'M02: Posts, comments and public timeline'

     parameters:


     responses:
       '200':
         description: 'Ok. Show Public Timeline'
         
 /posts/create:
   get:
     operationId: R203
     summary: 'R203: Post creation Form'
     description: 'Show post creation form. Access: OWN, ADM'
     tags:
       - 'M02: Posts, comments and public timeline'

     parameters:

     responses:
       '200':
         description: 'Ok. Show Post Creation Form UI'
         
   post:
     operationId: R204
     summary: 'R204: Create Post Action'
     description: 'Retrieves information and creates post. Access: OWN'
     tags:
       - 'M02: Posts, comments and public timeline'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               text:
                 type: string
             required:
                                    -text

     responses:
       '302':
         description: 'Redirect after the creation.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful creation. Redirect to user page.'
                 value: '/users/{id}'
               302Failure:
                 description: 'Failed creation. Redirect to user page.'
                 value: '/users/{id}'
         
     
 /posts/edit/{id}:
   get:
     operationId: R205
     summary: 'R205: Post edition Form'
     description: 'Show post edition form. Access: OWN'
     tags:
       - 'M02: Posts, comments and public timeline'

     parameters:
          - in: path
            name: id
            schema: 
             type: integer
            required: true

     responses:
       '200':
         description: 'Ok. Show Post Edit Form UI'
         
   post:
     operationId: R206
     summary: 'R206: Edit Post Action'
     description: 'Retrieves information and edits post. Access: OWN'
     tags:
       - 'M02: Posts, comments and public timeline'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               text:
                 type: string
             required:
                                    -text

     responses:
       '302':
         description: 'Redirect after the edition.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful edit. Redirect to user page.'
                 value: '/users/{id}'
               302Failure:
                 description: 'Failed edit. Redirect to user page.'
                 value: '/users/{id}'
         
```


## A8: Vertical Prototype

### Implemented features

#### User Stories

| Identifier | Name | Priority | Description |
| -------- | -------- | -------- | ------- |
| US05 | Search | Medium | As a User, I want to search for people and things, so that I can quickly find them with little effort.|
| US01     | Sign-Up  | High     | As a Visitor, i want to register an account in the system, so i can sign into it later. |
| US02     | Sign-In  | High | As a Visitor, i want to log into the system so i can access all the funcionalities available for me. |
| US101     | Sign-Out | High | As a User, I want to end my session, so that I can change account or protect my privacy in a shared computer. |
| US104 | Make Post | High | As a user, I want to create posts, so that I can share with my followers what I'm up to.|
| US121 | Update profile information | High | As a user, I want to update my profile information, so that it is always updated and reflecting how I see myself.|
| US106 | Remove Post | Medium | As a user, I want to remove posts I've made, so that I can hide things I no longer identify with.|
| US105 | Edit Post | Low | As a user, I want to edit my posts, so that I can hide embarassing grammar mistakes and correct misinformation.|
| US502| Remove a post from general feed|High| As a moderator, I want to remove certain posts from the feed so that everything is according to the guidelines.|


#### Web Resources

__Module M01: Authentication and User Profiles__


| Web Resource | URL | 
| -------- | -------- | 
| R101:Login Form    | GET/login  | 
| R102: Login Action | POST/login|
| R103: Logout Action | POST/logout|
| R104: Register Form | GET/register|
| R105: Register Action | POST/register|
| R106: View User Profile | GET/users/{id}|
| R107: Edit User Profile Form | GET/users/edit/{id}|
| R108: Update Profile Action | POST/users/edit/{id}|
| R109: Delete User profile Confirmation | GET/users/delete/{id}|
| R110: Delete User Action | POST/users/delete/{id}|


__Module M02: Posts, comments and public timeline__

| Web Resource | URL | 
| -------- | -------- | 
| R201: Main Page/ Public Timeline | GET/|
| R202: Delete Post    | POST/users/{id}  | 
| R203: Post Creation Form | GET/posts/create|
| R204: Create Post Action | POST/posts/create|
| R205: Edit Post Form | GET/posts/edit/{id}|
| R206: Edit Post Action |POST/posts/edit/{id}|

 

***
GROUP2141, 10/11/2021

* Lara Médicis, up201806762@fe.up.pt 
* Diogo Maia, up201904974@fe.up.pt 
* Luís Viegas, up201904979@fe.up.pt 
* Pedro Lima, up201605125@fe.up.pt
