# ER: Requirements Specification Component

> Project vision.

## A1: Project Name

> ProteinGram is a social network dedicated to people who work out, whether at home or in a gym, with its main goal being to provide an easier way for these people to connect and  cultivate friendships within the community, further inspiring each other with their progress. Right from the start, a team of administrators is defined, this team will ensure everyone sticks to community guidelines and social norms regarding public behavior are followed.

>ProteinGram allows registered users to interact with each other, whether that be through private messaging, within groups, or on the timeline. Gyms and gym-related companies will also be able to register as such so they can better interact with their target clients. 

>ProteinGram allows users to post public and private messages that can include web links or images. They will also be able to interact with other user content (comment, react, like, reply) and have their own content be interacted with, as long as the permission requirements are met. 

>The website will contain a search feature through which users will be able to find other users, groups, and pages. Users and groups that are private will not have their content viewed by users who aren’t friends with said user or aren’t members of said group.

>Anyone can join a public group, where they can post and interact with other people’s content, however a user has to request to join a private group and be approved by the admins in order to be added.

>Non-authenticated users will be able to view any public content on the platform, but will not however be able to interact with this content.



---


## A2: Actors and User stories

> In this artefact, we intend to present all the types of users we want to engage with our system, their utilities and all they can do. Furthermore, we want to show what are our business rules, technical rules and, in the end, the restrictions that made us decide what we can and cannot implement.


### 1. Actors

> The actors in **ProteinGram** are the ones represented in **Figure 1** and are described in **Table 1**.

![](https://i.imgur.com/ckMv11I.jpg)

 
<center> Figure 1 - ProteinGram Actors </center><br>


| Actor | Descripton |
| -------- | -------- |
| User     | Common user that can access most information from public groups' feed and public users' posts.  |
| Visitor    |  Unauthenticated user that can register or sign-in to the website while still has access to public information.    |
| Registered User     | Registered user can post text and/or images on their feed, edit their own profiles, comment on other users' posts, befriend other users and chat privately with them.     |
| Group Owner     | Group Owner can use his group to advertise and share what he wants. He can decide if the group is private or public and control whatever information is shared there. He can also select whoever he wants to also receive this status.    |
| Group User| Group user can post text/images on the group's feed and comment on those posts. |
| Administrator     | Administrator is responsable to make everything run as smoothly as it can. He can assign and remove the moderator credentials.    |
| Moderator     | Moderator should moderate all the content on the website.  |
| OAuth API     | External OAuth API that can be used to register or authenticate into the system.     |
<center>Table 1 - ProteinGram actors descriptions</center>

### 2. User Stories

> User stories organized by actor.  
> For each actor, a table containing a line for each user story, and for each user story: an identifier, a name, a priority, and a description (following the recommended pattern).

#### 2.1. User
| Identifier | Name | Priority | Description |
| -------- | -------- | -------- | ------- |
| US05 | Search | Medium | As a User, I want to search for people and things, so that I can quickly find them with little effort.|

<center>Table 2 - ProteinGram general user stories</center>

#### 2.2. Visitor

| Identifier | Name | Priority | Description |
| -------- | -------- | -------- | ------- |
| US01     | Sign-Up  | High     | As a Visitor, i want to register an account in the system, so i can sign into it later. |
| US02     | Sign-In  | High | As a Visitor, i want to log into the system so i can access all the funcionalities available for me. |
| US03     | OAuth API Sign-Up     | Low     | As a visitor, i want to Sign-Up without the need to create a whole new account, thus using a Google Account existing one. |
| US04     | OAuth API Sign-In     | Low     | As a visitor, i want to Sign-In using my Google Account. |
<center>Table 3 - ProteinGram visitors stories</center>

#### 2.3. Registered User
| Identifier | Name | Priority | Description |
| -------- | -------- | -------- | ------- |
| US101     | Sign-Out | High | As a User, I want to end my session, so that I can change account or protect my privacy in a shared computer. |
| US102 | Add Friend | High | As a User, I want to add friends, so that I can see their private information or posts and easily stay up to date with new posts. |
| US104 | Make Post | High | As a user, I want to create posts, so that I can share with my followers what I'm up to.|
| US107 | Like Post | High | As a user, I want to like posts I see, so that I can let others know I enjoyed them.|
| US108 | Comment on Post | High | As a user, I want to comment on posts, so that I can show others what I think about their post and interact with them.|
| US110 | Like Comment | High | As a user, I want to like comments on posts, so that I can show my appreciation for the commentor's comment. |
| US113 | Send Message | High | As a user, I want to send messages to other users, so that I can privately communicate with them. |
| US115 | Create Group | High | As a user, I want to create a group, so that I can have others join a community over a shared interest. |
| US116 | Join Public Group | High | As a user, I want to join public groups, so that I easily get the group's content in my feed.|
| US119 | Change Password | High | As a user, I want to change my password, so that I can protect my account better.|
| US121 | Update profile information | High | As a user, I want to update my profile information, so that it is always updated and reflecting how I see myself.|
| US106 | Remove Post | Medium | As a user, I want to remove posts I've made, so that I can hide things I no longer identify with.|
| US122 | Post Media | Medium | As a user, I want to upload media (such as images and video) to a post i'm making, so that I can have more interesting posts that better show myself and my gains.|
| US112 | Remove Comment | Medium | As a user, I want to remove comments I've made, so that I can hide things I no longer identify with. |
| US118 | Respond to Group Invitations | Medium | As a user, I want to easily respond to group invitations I've received.|
| US103 | Remove Friend | Medium | As a User, I want to remove friends, so that I can control who has access to my private information.|
| US105 | Edit Post | Low | As a user, I want to edit my posts, so that I can hide embarassing grammar mistakes and correct misinformation.|
| US109 | Reply to Comments | Low | As a user, I want my comments to be able to be a reply, so that it is clear they're intended as a response to another comment.|
| US111 | Edit Comment | Low | As a user, I want to edit comments I've made, so that I can hide embarassing grammar mistakes and correct misinformation.|
| US117 | Ask to join Private Group | Low | As a user, I want to request to join a private group, so that I can post and see the content shared in it.|
| US120 | Change E-mail Account | Low | As a user, I want to change the e-mail associated with my account, so that I can protect my account from e-mail security problems.|
| US123 | Post Links with Integration | Low | As a user, I want the links in my post to show their content embedded in the post, so that I can easily share things from other sources in a way that doesn't require others to leave ProteinGram.|

<center>Table 4 - ProteinGram registered user stories</center>
#### 2.4. Group Owner

| Identifier | Name | Priority | Description |
| -------- | -------- | -------- | ------- |
| US201 | Delete group | High | As a Group Owner, i want to delete the group that i previously created. |
| US202 | Rename group | medium | As a Group Owner, i want to change the name of my group. |
| US203 | Invite member | High | As a Group Owner, i want to invite an user to my group, so that he becomes a member of my group if he accepts the invitation. |
| US204 | Accept member | High | As a Group Owner, i want to accept a request from a registered user to join my group.|
| US205 | Remove member | High | As a Group Owner, i want to kick a member from my group, so that he can no longer access this group's information. |
| US207 | Delete post | Medium | As a Group Owner, i want to delete a post from my group, regardless if i posted it or not. |
| US208 | Reject member | Low | As a Group Owner, i want to reject a request from a member, so that he can be informed that i rejected his request to be a member of the group.|
<center>Table 5 - ProteinGram group owner stories</center>

#### 2.5. Group User

| Identifier | Name | Priority | Description |
| -------- | -------- | -------- | ------- |
| US301 | Post on group | High | As a group user, i want to create a post on the group so other members can interact with it.|
| US302 | Leave group | High | As a group user, i want to leave the group so that I no longer receive posts from the group and i'm not longer part of it.|

<center>Table 6 - ProteinGram group user stories</center>



#### 2.6. Moderator

| Identifier | Name | Priority | Description |
| -------- | -------- | -------- | ------- |
| US501| Check list of posts| High| As a moderator, I want to check from a list the posts that need to be analyzed so that I can review all the posts|
| US502| Remove a post from general feed|High| As a moderator, I want to remove certain posts from the feed so that everything is according to the guidelines.|
|US503 | Remove a comment from certain post|High| As a moderator, I want to remove certain comments so that everything is according to the guidelines.|
|US504| Check reports received| Medium| As a moderator, I want to check a list of reports made so that I can check whether if these are harmfull or not.|
|US505| Suspend account| Medium | As a moderator, I want to be able to suspend accounts that disrespected the website's guidelines too much so that the content is safe for every user.|

<center>Table 7 - ProteinGram moderator stories</center>

#### 2.7. Administrator

| Identifier | Name | Priority | Description |
| -------- | -------- | -------- | ------- |
| US401| Create moderator account| high| As an administrator, I want to add moderators to the website so that the website can be sustained.|
| US402| Remove moderator account |medium| As an administrator, I want to remove moderators so that administrators can remove moderator that don't behave as recommended.|

<center>Table 8 - ProteinGram administrator stories</center>


### 3. Supplementary Requirements

>Ahead of this text, there are 3 tables. The first one represents all the business rules we attend to respect when thinking about the system we want to build. The second one shows all the technical aspects of the system we want to achieve and the third one is responsible to show every restriction we have to implement everything on our minds.

#### 3.1. Business rules
| Identifier | Name | Description |
| -------- | -------- | ------- |
|BR01| All posts should consist on text and/or pictures.|  The content the users can share in posts is images and text|
| BR02 | Content created by a deleted user stays on the database| When a user is deleted, by itself or by a moderator/admin, all it's content (posts and comments) remain on the database so that we can track all that is happening on network.|
| BR03| An user can comment on his own post | An user should be able to comment on their on posts, so they can answer other replies or extend the topic of the post in case.|
| BR04 | All people attending this website should be older then 16| The birthday date of a personal user account should be more than 16 years ago.|

<center>Table 9 - ProteinGram business rules</center>

#### 3.2. Technical requirements

| Identifier | Name | Description |
| -------- | -------- | ------- |
|TR01 | Portability | The website should be able to run on every OS like Linux, macOS and Windows. This should also happen if the user is logging in an Android or IOS smartphone or a tablet.|
|**TR02** | Security | The website is responsable to keep safe every private information not allowing information leaks like user's private data and private messages'.|
|**TR03**| Performance | The website should and must run smoothly on every device and brownser.|
|**TR04**| Avaibility | The system should be avaiable to every user most of the time, warning previously every maintenance in about to happen.|
|TR05 | Database | The system should have a well organized database to work as the base for a good website. The database management must be constant in a way to prevent any errors.|
|TR06| Robustness | The system must work, even when a runtime error occurs.|

<center>Table 10 - ProteinGram technical</center>


#### 3.3. Restrictions

| Identifier | Name | Description |
| -------- | -------- | ------- |
|C01| Deadline | The system should be ready to work before the end of January.|

<center>Table 9 - ProteinGram restrictions</center>

---


## A3: Information Architecture

> In this artefact, we intend to show how we structured our system from creating a sitemap to present how we will divide the system information in pages to designing some wireframes to show the page's format in more detail.


### 1. Sitemap

> ProteinGram is organized in four main areas:
> * Static pages - provide general information to users such as terms & conditions, contacts, and privacy policy
> * User Pages - access to a user's own page, profile settings, friends' pages & groups
> * Private Messaging - where users can access their private messages with other users
> * Admin Pages - acess to administration features

![](https://i.imgur.com/JuAPMBJ.png)
<center> Figure 2 - Sitemap </center><br>



### 2. Wireframes

> The ProteinGram Wireframes for the Main Timeline (UI01) and the User Profile (UI10) are presented below, in Figures 2 and 3, respectively.


#### UI01: Main Timeline

![](https://i.imgur.com/4qv34lk.png)

<center> Figure 3 - Main Timeline (UI01) Wireframe </center><br>


#### UI10: User Profile

![](https://i.imgur.com/cVfWVwF.png)

<center> Figure 4 - User Profie (UI10) Wireframe </center><br>

[Link](https://xd.adobe.com/view/a917625e-ff89-4508-8c55-b427b1334f68-fc44/?fullscreen) to Wireframes with minimal navigation.





***
GROUP2141, 10/11/2021

* Lara Médicis, up201806762@fe.up.pt (Editor)
* Diogo Maia, up201904974@fe.up.pt (Author)
* Luís Viegas, up201904979@fe.up.pt (Author)
* Pedro Lima, up201605125@fe.up.pt (Author)
