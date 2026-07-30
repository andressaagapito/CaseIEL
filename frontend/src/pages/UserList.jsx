import { useState, useEffect } from 'react';
import { API_URL } from '../config';

function UserList() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [filter, setFilter] = useState('todos');

  const fetchUsers = async () => {
    setLoading(true);
    setError(null);
    try {
      let url = `${API_URL}/users`;
      if (filter !== 'todos') {
        url += `?status=${filter}`;
      }
      const response = await fetch(url);
      if (!response.ok) {
        throw new Error('Falha ao buscar usuários');
      }
      const data = await response.json();
      setUsers(data);
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchUsers();
  }, [filter]);

  const handleInactivate = async (id) => {
    try {
      const response = await fetch(`${API_URL}/users/${id}/inactivate`, {
        method: 'PATCH',
      });
      
      if (!response.ok) {
        throw new Error('Erro ao inativar usuário');
      }
      
      setUsers(users.map(user => 
        user.id === id ? { ...user, status: 'inativo' } : user
      ));
    } catch (err) {
      alert(err.message);
    }
  };

  return (
    <div className="glass-card table-card">
      <div className="card-header">
        <h2>Usuários do Sistema</h2>
        <p>Listagem de todos os usuários cadastrados.</p>
      </div>

      <div className="filter-container">
        <label htmlFor="status-filter">Filtrar por Status:</label>
        <div className="select-wrapper">
          <select
            id="status-filter"
            value={filter}
            onChange={(e) => setFilter(e.target.value)}
          >
            <option value="todos">Todos</option>
            <option value="ativo">Ativos</option>
            <option value="inativo">Inativos</option>
          </select>
        </div>
      </div>

      {error && (
        <div className="alert alert-error">
          {error}
        </div>
      )}

      {loading && (
        <div className="loading-state">Carregando usuários...</div>
      )}

      {!loading && !error && users.length === 0 && (
        <div className="empty-state">Nenhum usuário encontrado.</div>
      )}

      {!loading && !error && users.length > 0 && (
        <div className="table-responsive">
          <table className="users-table">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              {users.map(user => (
                <tr key={user.id}>
                  <td>{user.nome}</td>
                  <td>{user.email}</td>
                  <td>
                    <span className={`status-badge status-${user.status.toLowerCase()}`}>
                      {user.status}
                    </span>
                  </td>
                  <td>
                    <button 
                      className="btn-inativar"
                      onClick={() => handleInactivate(user.id)}
                      disabled={user.status.toLowerCase() === 'inativo'}
                    >
                      {user.status.toLowerCase() === 'inativo' ? 'Inativado' : 'Inativar'}
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );
}

export default UserList;
