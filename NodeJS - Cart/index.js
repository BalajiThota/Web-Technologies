const express = require('express');
const app = express();

const mysql = require('mysql');
const json2csv = require('json2csv').parse;
const body = require('body-parser');
const url=require('url')
var session = require('express-session');

app.use(express.static('public'));

app.set('view engine','ejs');
app.use(express.json());
app.use(body.json());
app.use(body.urlencoded({ extended: true }));

app.use(session({secret: 'Your_Secret_Key', resave: true, saveUninitialized: true}))


// create a connection to the MySQL database
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'cart'
});

// connect to the MySQL database
connection.connect(err => {
  if (err){
  console.log(err);
  }
  else{
  console.log('Connected to the MySQL database');
  }
});

// serve the home page
app.get('/', (req, res) => {
  res.sendFile(__dirname + '/static' +'/home.html');
});

// serve the admin login page
app.get('/alogin', (req, res) => {
  res.render('alogin');
});

// serve the user login page
app.get('/login', (req, res) => {
  res.render('login');
});

app.get('/cart', (req,res)=>{
  if(req.session.logged === false){
    res.redirect('/login');
  }
  else{
  var sql = "SELECT *FROM cart WHERE email = ?";
  connection.query(sql,[req.session.email] ,(err, results) => {
    if (err) {
      throw err;
    }
    res.render('cart',{products:results , cartno:req.session.cartno});
  
  });
}
});


//Create Route for Remove Item from Shopping Cart

// app.post('/cart', function(req, res) {
//   // Get the ID of the item to remove
//   const id = req.body.id;
//   console.log(id);

//   // Find the item in the cart by ID and remove it
//   for (let i = 0; i < cart.length; i++) {
//     if (cart[i].id === id) {
//       cart.splice(i, 1);
//       break;
//     }
//   }

//   // Send a response back to the client to indicate success
//   res.send('success');
// });

app.get('/cart', (req, res) => {
  if(req.session.logged){
    const sql = 'SELECT * FROM products';
    connection.query(sql, (err, results) => {
    if (err) {
      console.log('1'+err);
    }
    const sql1 = "SELECT * FROM category";
    connection.query(sql1, (err, result) => {
      if (err) {
        console.log('2'+err);
      }
      connection.query("SELECT *FROM register WHERE email = ?",[req.session.email], (err, re) => {
        if (err) {
          console.log('3'+err);
        }
        req.session.cartno = re[0]['tot_items'];
      res.render('cart', {products:results, category:result , cartno:re[0]['tot_items'],log:req.session.logged});
    });
    });
    });

  }
});


app.post('/cart', (req, res) => {
  console.log(req.body);
  	const id = req.body.id;
  var product_id=id[0];
  console.log(req.body);
  console.log(product_id);
  console.log(100000);
  connection.query("SELECT *FROM cart WHERE email = ? and id = ?",[req.session.email,id], (err, results) => {
    if (err) {
      console.log('1'+err);
    }
    var a = results[0]['quantity'];
    console.log(a);
    console.log(200000);
    connection.query("DELETE FROM cart WHERE id = ? AND email = ?",[id,req.session.email], (err, results) => {
      if (err) {
        console.log('2'+err);
      }
      console.log(300000);
      connection.query("UPDATE register SET tot_items = tot_items - ? WHERE email = ?",[a,req.session.email], (err, results) => {
        if (err) {
          console.log('3'+err);
        }
        console.log(400000);
      });
    });
  });
	res.redirect('/dash');
});


app.get('/signup', (req, res) => {
  res.render('signup');
});

app.get('/adash',(req,res)=>{
  if(req.session.logged){
    const sql = 'SELECT * FROM products';
    connection.query(sql, (err, results) => {
      if (err) {
        throw err;
      }
      const sql1 = "SELECT * FROM category";
      connection.query(sql1, (err, result) => {
        if (err) {
          throw err;
        }
        res.render('adash', {products:results, category:result});
    });
    });
    }
  else{
    res.render('login');
  }
});

app.get('/newprod',(req,res)=>{
  connection.query("SELECT *FROM category", (err, re) => {
    if (err) {
      throw err;
    }
    console.log(re);
    res.render('newproduct',{category:re});
});
});

app.get('/newcat',(req,res)=>{
  res.render('newcat');
});

app.get('/dash', (req, res) => {
  if(req.session.logged){
    const sql = 'SELECT * FROM products';
    connection.query(sql, (err, results) => {
    if (err) {
      throw err;
    }
    const sql1 = "SELECT * FROM category";
    connection.query(sql1, (err, result) => {
      if (err) {
        throw err;
      }
      connection.query("SELECT *FROM register WHERE email = ?",[req.session.email], (err, re) => {
        if (err) {
          throw err;
        }
        req.session.cartno = re[0]['tot_items'];
      res.render('dashboard', {products:results, category:result , cartno:re[0]['tot_items'],log:req.session.logged});
    });
    });
    });

  }
  else{
    res.render('login');
  }
});



// sign up page
app.post('/signup', (req, res) => {
  const feilds = ['name', 'email', 'pass'];
  const name = req.body.name;
  const email = req.body.email;
  const password = req.body.password;
  // insert the sign-up data into the database
  connection.query('INSERT INTO register (name, email, pass) VALUES (?, ?, ?)', [name, email, password], (err, results, fields) => {
    if (err) {
      console.error('Error inserting sign-up data: ' + err.stack);
      res.send('Error inserting sign-up data.');
      return;
    }
    console.log('Sign-up data inserted into database with ID ' + results.insertId);
    res.redirect('/login');
  });
});

app.post('/login', (req, res) => {
  const feilds = ['email', 'pass'];
  const email = req.body.email;
  const password = req.body.password;
  // insert the sign-up data into the database
  connection.query('SELECT *FROM register WHERE email = ? and pass = ?', [ email, password], (err, results) => {
    if (err) {
      console.error('Error');
      res.send('Error');
      return;
    }
    if(results.length>0){
    console.log('login Sucessful');
    req.session.user = results[0]['name'];
    req.session.email = results[0]['email'];
    req.session.cartno = results[0]['tot_items'];
    req.session.logged = true;
    res.redirect('/dash');
    }
    else{
      console.log('unSucessful');
      res.redirect('/login');
    }
  });
});


app.post('/alogin', (req, res) => {
  const feilds = ['email', 'pass'];
  const email = req.body.email;
  const password = req.body.password;
  console.log(email,password);
  // insert the sign-up data into the database
    if(email == 'admin' && password == '123'){
    console.log('login Sucessful');
    req.session.logged = true;
    res.redirect('/adash');
    }
    else{
      console.log('unSucessful');
      res.redirect('/login');
    }
  });
  

  app.post('/newcat', (req, res) => {
    if(req.session.logged)
    {
    const feilds = ['category'];
    const cat_name = req.body.category;
    connection.query('INSERT IGNORE INTO category(cat_name) values(?)', [ cat_name ], (err) => {
      if (err) {
        console.error('Error');
        res.send('Error');
        return;
      }
      res.redirect('/adash');
  });
}
else{
  res.redirect('/login');
}
});



app.get('/logout',(req,res)=>{
  console.log(req.session.logged);
  req.session.logged = false;
  console.log(req.session.logged);
  req.session.user = null;
  req.session.destroy;
  res.redirect('/login');
});

app.listen(3000, () => {
  console.log('Server started on port 3000');
});

// upload image
const path = require('path');
const multer = require('multer');
const storage =multer.diskStorage({
    destination: (req,file, cb) => {
       return cb(null, './public/images');
    },
    filename: function (req, file, cb) {
        return cb(null, `${Date.now()}-${file.originalname}`);
    },
});
const upload = multer({storage});
app.set("view engine","ejs");
app.set("views", path.resolve("./views"));
app.use(express.urlencoded({extended: false }));

app.post("/newprod", upload.single("image"), (req, res) => {
  const feilds = ["name", "category", "price", "description", "image"];
  const name = req.body.name;
  const category = req.body.category;
  const price = req.body.price;
  const description = req.body.description;
  const img = req.file.filename;

  connection.query(
    "INSERT INTO products (id, category, name, description, img, price) VALUES (NULL, ?, ?, ?, ?, ?)",
    [category, name, description, img, price],
    (err, results, fields) => {
      if (err) {
        console.error("Error inserting sign-up data: " + err.stack);
        res.send("Error inserting sign-up data.");
        return;
      }
      console.log("Sign-up data inserted into database with ID " + results.insertId);

      return res.redirect("/adash");
    });
});

app.post('/dash',(req,res)=>{
  feilds = ['id', 'product_name', 'product_price'];
  connection.query(
    "SELECT *FROM cart WHERE email = ? and id = ?",
    [req.session.email,req.body.id],
    (err, results, fields) => {
      if (err) {
        console.log("error 1"+err.stack);
        return;
      }
      connection.query(
        "UPDATE register SET tot_items = tot_items + 1 WHERE email = ?",
        [req.session.email],
        (err, results, fields) => {
          if (err) {
            console.log("error 1"+err.stack);
            return;
          }
        });
      console.log(1000);
      if(results.length == 0){
        console.log(req.session.email,parseInt(req.body.id),1,parseInt(req.body.price),req.body.name);
        connection.query(
          "INSERT INTO cart (email, id, quantity, price , name ) VALUES (?, ?, ?, ?, ?)",
          [req.session.email,parseInt(req.body.id),1,parseInt(req.body.price),req.body.name],
          (err, results) => {
            if (err) {
              console.error("Error inserting cart table" + err.stack);
              return;
            }
            console.log(200000);
            console.log("Sign-up data inserted into database with ID ");
      
            return res.redirect("/dash");
          });
      }
      else{
        connection.query(
          "UPDATE cart SET quantity = quantity + 1 WHERE email = ? and id = ?;",
          [req.session.email,req.body.id],
          (err, results) => {
            if (err) {
              console.error("Error updating" + err.stack);
              res.send("Error inserting sign-up data.");
              return;
            }
            console.log("updated");
      
            return res.redirect("/dash");
          });
      }
    });
});


app.listen(8000);
console.log("3000 is the port");