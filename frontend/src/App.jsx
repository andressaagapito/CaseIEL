import { useState } from 'react';
import UserForm from './pages/UserForm';
import UserList from './pages/UserList';
import './App.css';

function App() {
  const [activePage, setActivePage] = useState('form');

  return (
    <div className="app-container">
      <div className="nav-container">
        <button 
          className={`nav-btn ${activePage === 'form' ? 'active' : ''}`}
          onClick={() => setActivePage('form')}
        >
          Novo Cadastro
        </button>
        <button 
          className={`nav-btn ${activePage === 'list' ? 'active' : ''}`}
          onClick={() => setActivePage('list')}
        >
          Lista de Usuários
        </button>
      </div>

      <div className="page-content">
        {activePage === 'list' ? <UserList /> : <UserForm />}
      </div>
    </div>
  );
}

export default App;
