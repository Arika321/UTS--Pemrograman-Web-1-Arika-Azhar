const express = require('express');
const cors = require('cors');
const fs = require('fs');
const path = require('path');
const bodyParser = require('body-parser');

const app = express();
app.use(cors());
app.use(bodyParser.json());

const DBFILE = path.join(__dirname, 'db.json');

function readDB(){
  const raw = fs.readFileSync(DBFILE);
  return JSON.parse(raw);
}
function writeDB(obj){
  fs.writeFileSync(DBFILE, JSON.stringify(obj, null, 2));
}

// GET all products
app.get('/api/products', (req, res) => {
  const db = readDB();
  res.json(db.products);
});

// GET product by id
app.get('/api/products/:id', (req, res) => {
  const db = readDB();
  const id = parseInt(req.params.id);
  const p = db.products.find(x => x.id === id);
  if (!p) return res.status(404).json({error:'Not found'});
  res.json(p);
});

// CREATE product
app.post('/api/products', (req, res) => {
  const db = readDB();
  const newId = db.products.length ? Math.max(...db.products.map(p=>p.id)) + 1 : 1;
  const p = { id: newId, ...req.body };
  db.products.push(p);
  writeDB(db);
  res.json({success:true, product:p});
});

// UPDATE product
app.put('/api/products/:id', (req, res) => {
  const db = readDB();
  const id = parseInt(req.params.id);
  const idx = db.products.findIndex(x => x.id === id);
  if (idx === -1) return res.status(404).json({error:'Not found'});
  db.products[idx] = { ...db.products[idx], ...req.body, id };
  writeDB(db);
  res.json({success:true, product:db.products[idx]});
});

// DELETE product
app.delete('/api/products/:id', (req, res) => {
  const db = readDB();
  const id = parseInt(req.params.id);
  db.products = db.products.filter(x => x.id !== id);
  writeDB(db);
  res.json({success:true});
});

app.listen(3000, () => console.log('API running at http://localhost:3000'));
