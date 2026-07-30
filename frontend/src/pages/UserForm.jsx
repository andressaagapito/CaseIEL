import { useState } from 'react';
import { API_URL } from '../config';

function UserForm() {
  const [formData, setFormData] = useState({
    nome: '',
    email: '',
    senha: '',
    status: 'ativo'
  });
  
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState({ type: '', text: '' });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setMessage({ type: '', text: '' });

    try {
      const response = await fetch(`${API_URL}/users`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
      });

      const data = await response.json();

      if (response.ok) {
        setMessage({ type: 'success', text: 'Usuário cadastrado com sucesso!' });
        setFormData({ nome: '', email: '', senha: '', status: 'ativo' });
      } else {
        setMessage({ type: 'error', text: data.error || 'Erro ao cadastrar usuário.' });
      }
    } catch (error) {
      setMessage({ type: 'error', text: 'Erro de conexão com o servidor.' });
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="glass-card">
      <div className="card-header">
        <h2>Novo Cadastro</h2>
        <p>Preencha os dados abaixo para registrar um novo usuário no sistema.</p>
      </div>

      {message.text && (
        <div className={`alert alert-${message.type}`}>
          {message.text}
        </div>
      )}

      <form onSubmit={handleSubmit} className="register-form">
        <div className="input-group">
          <label htmlFor="nome">Nome</label>
          <input
            type="text"
            id="nome"
            name="nome"
            value={formData.nome}
            onChange={handleChange}
            placeholder="Nome"
            required
          />
        </div>

        <div className="input-group">
          <label htmlFor="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            value={formData.email}
            onChange={handleChange}
            placeholder="seu@email.com"
            required
          />
        </div>

        <div className="input-group">
          <label htmlFor="senha">Senha</label>
          <input
            type="password"
            id="senha"
            name="senha"
            value={formData.senha}
            onChange={handleChange}
            placeholder="Senha"
            required
          />
        </div>

        <div className="input-group">
          <label htmlFor="status">Status</label>
          <div className="select-wrapper">
            <select
              id="status"
              name="status"
              value={formData.status}
              onChange={handleChange}
              required
            >
              <option value="ativo">Ativo</option>
              <option value="inativo">Inativo</option>
            </select>
          </div>
        </div>

        <button type="submit" className="submit-btn" disabled={loading}>
          {loading ? 'Processando...' : 'Cadastrar'}
        </button>
      </form>
    </div>
  );
}

export default UserForm;
