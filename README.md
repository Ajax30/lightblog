# What is this about? 

This is a simple, easy to use, blogging (or online newspaper) application.

![Homepage preview](https://github.com/Ajax30/lightblog/blob/master/preview.jpg)

# How to use this CMS

I have created a simple installation process: after creating a database and providing its credentials to the `application/config/database.php` file, you can run the `Install` controller which will create all the necessary tables.

After that, you can register as an **author**. Being the first registered author, you are also an admin, meaning that your author account *does not require activation* (and the value for the `is_admin` column has a value of `1` in the database record for you). 

All the future authors will need their accounts *activated by you* in order to publish articles (posts).


# Demo video

I have created a short demo **video**.

[![Demo video](https://github.com/Ajax30/lightblog/blob/master/video-thumbnail.png)](http://www.youtube.com/watch?v=T71prYUuqgc)


# License

MIT License

Copyright (c) 2020 Razvan Zamfir

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.