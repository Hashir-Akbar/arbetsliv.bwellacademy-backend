import React, { useState } from 'react';

const Home = () => {
  const [title, setTitle] = useState('Hello, React!');

  return (
    <div>
      <h1>{title}</h1>
    </div>
  );
};

export default Home;