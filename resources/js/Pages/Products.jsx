import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Modal, Button, Form } from 'react-bootstrap';

const Products = () => {
  // Estado para armazenar a lista de produtos
  const [products, setProducts] = useState([]);

  // Estados para controlar os modais
  const [showAddModal, setShowAddModal] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);

  // Estado para armazenar o produto selecionado para exclusão
  const [productToDelete, setProductToDelete] = useState(null);

  // Estado para armazenar os dados do novo produto
  const [newProduct, setNewProduct] = useState({
    nome: '',
    descricao: '',
    estoque: 0,
  });

  // Função para buscar os produtos da API
  const fetchProducts = async () => {
    try {
      const response = await axios.get('/api/produtos');
      setProducts(response.data);
    } catch (error) {
      console.error('Erro ao buscar produtos:', error);
    }
  };

  // Buscar produtos quando o componente for montado
  useEffect(() => {
    fetchProducts();
  }, []);

  // Função para adicionar um novo produto
  const handleAddProduct = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post('/api/produtos', newProduct);
      // Atualiza a lista adicionando o novo produto
      setProducts([...products, response.data.produto]);
      setShowAddModal(false);
      // Reseta o formulário
      setNewProduct({ nome: '', descricao: '', estoque: 0 });
    } catch (error) {
      console.error('Erro ao adicionar produto:', error);
    }
  };

  // Abre o modal de exclusão para um produto específico
  const openDeleteModal = (product) => {
    setProductToDelete(product);
    setShowDeleteModal(true);
  };

  // Função para excluir um produto
  const handleDeleteProduct = async () => {
    try {
      await axios.delete(`/api/produtos/${productToDelete.id}`);
      // Atualiza a lista removendo o produto excluído
      setProducts(products.filter(p => p.id !== productToDelete.id));
      setShowDeleteModal(false);
      setProductToDelete(null);
    } catch (error) {
      console.error('Erro ao excluir produto:', error);
    }
  };

  return (
    <div className="container mt-4">
      <h1>Gerenciamento de Produtos</h1>

      {/* Botão para abrir o modal de adicionar produto */}
      <Button variant="primary" onClick={() => setShowAddModal(true)}>
        Adicionar Produto
      </Button>

      {/* Tabela de produtos */}
      <table className="table mt-3">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Estoque</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          {products.map(produto => (
            <tr key={produto.id}>
              <td>{produto.id}</td>
              <td>{produto.nome}</td>
              <td>{produto.descricao}</td>
              <td>{produto.estoque}</td>
              <td>
                {/* Botão para abrir o modal de exclusão */}
                <Button variant="danger" onClick={() => openDeleteModal(produto)}>
                  Excluir
                </Button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>

      {/* Modal para adicionar um produto */}
      <Modal show={showAddModal} onHide={() => setShowAddModal(false)}>
        <Modal.Header closeButton>
          <Modal.Title>Adicionar Produto</Modal.Title>
        </Modal.Header>
        <Form onSubmit={handleAddProduct}>
          <Modal.Body>
            <Form.Group controlId="nome">
              <Form.Label>Nome</Form.Label>
              <Form.Control
                type="text"
                value={newProduct.nome}
                onChange={(e) => setNewProduct({ ...newProduct, nome: e.target.value })}
                required
              />
            </Form.Group>
            <Form.Group controlId="descricao" className="mt-2">
              <Form.Label>Descrição</Form.Label>
              <Form.Control
                as="textarea"
                value={newProduct.descricao}
                onChange={(e) => setNewProduct({ ...newProduct, descricao: e.target.value })}
              />
            </Form.Group>
            <Form.Group controlId="estoque" className="mt-2">
              <Form.Label>Estoque</Form.Label>
              <Form.Control
                type="number"
                value={newProduct.estoque}
                onChange={(e) => setNewProduct({ ...newProduct, estoque: parseInt(e.target.value) })}
                required
              />
            </Form.Group>
          </Modal.Body>
          <Modal.Footer>
            <Button variant="secondary" onClick={() => setShowAddModal(false)}>
              Cancelar
            </Button>
            <Button variant="primary" type="submit">
              Salvar
            </Button>
          </Modal.Footer>
        </Form>
      </Modal>

      {/* Modal para confirmar a exclusão do produto */}
      <Modal show={showDeleteModal} onHide={() => setShowDeleteModal(false)}>
        <Modal.Header closeButton>
          <Modal.Title>Confirmar Exclusão</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          Tem certeza que deseja excluir o produto "{productToDelete && productToDelete.nome}"?
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={() => setShowDeleteModal(false)}>
            Cancelar
          </Button>
          <Button variant="danger" onClick={handleDeleteProduct}>
            Excluir
          </Button>
        </Modal.Footer>
      </Modal>
    </div>
  );
};

export default Products;
