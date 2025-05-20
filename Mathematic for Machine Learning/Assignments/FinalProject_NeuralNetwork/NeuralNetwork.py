import matplotlib.pyplot as plt
import numpy as np

class Layer:
    def __init__(self, input_size, output_size, activation_func):
        self.weights = np.random.randn(output_size, input_size)
        self.biases = np.random.randn(output_size, 1)
        self.activation = activation_func 

class NeuralNetwork:
    def __init__(self):
        self.layers = []

    def add_layer(self, layer):
        self.layers.append(layer)

    @staticmethod
    def sigmoid(x):
     return 1 / (1 + np.exp(-x))

    @staticmethod
    def relu(x):
        return np.maximum(0, x)

    @staticmethod
    def sigmoid_derivative(x):
        s = NeuralNetwork.sigmoid(x)
        return s * (1 - s)

    @staticmethod
    def relu_derivative(x):
        return np.where(x > 0, 1, 0)

    def forward(self, inputs):
        activations = [inputs]
        zs = []
        current_output = inputs
        for layer in self.layers:
            z = np.dot(layer.weights, current_output) + layer.biases
            zs.append(z)
            current_output = layer.activation(z)
            activations.append(current_output)
        return activations, zs

    def train(self, inputs, target, learning_rate):
        activations, zs = self.forward(inputs)
        output = activations[-1]

        #delta = NeuralNetwork.mse(target, output)
        delta = (output - target)

        for i in reversed(range(len(self.layers))):
            layer = self.layers[i]
            z = zs[i]
            a_prev = activations[i]

            if layer.activation == NeuralNetwork.sigmoid:
                activation_derivative = NeuralNetwork.sigmoid_derivative(z)
            elif layer.activation == NeuralNetwork.relu:
                activation_derivative = NeuralNetwork.relu_derivative(z)
            else:
                raise Exception("Activation function derivative not defined")

            delta = delta * activation_derivative

            dw = np.dot(delta, a_prev.T)
            db = delta

            layer.weights -= learning_rate * dw
            layer.biases -= learning_rate * db

            if i != 0:
                delta = np.dot(layer.weights.T, delta)

    def fit(self, X, Y, learning_rate=0.01, epochs=1000, verbose=True):
        for epoch in range(epochs):
            loss = 0
            for x, y in zip(X, Y):
                x = x.reshape(-1, 1)
                y = y.reshape(-1, 1)
                self.train(x, y, learning_rate)
                output = self.forward(x)[0][-1]
                loss += NeuralNetwork.mse(y, output)
            loss /= len(X)
            if verbose and epoch % 100 == 0:
                print(f"Epoch {epoch}, Loss: {loss:.4f}")
    
    @staticmethod
    def mse(y_true, y_pred):
        return ((y_true - y_pred) ** 2).mean()




# Generating data for f(x) = exp(x)
X = np.linspace(0, 3, 100).reshape(-1, 1)
Y = np.exp(X)

# normalize
Y = Y / np.max(Y)  

# Define a rede
nn = NeuralNetwork()
nn.add_layer(Layer(1, 10, NeuralNetwork.sigmoid))
nn.add_layer(Layer(10, 1, NeuralNetwork.relu))

# Train the network
nn.fit(X, Y, learning_rate=0.01, epochs=2000)

# Test it and plot results
predictions = []
for x in X:
    x_input = x.reshape(-1, 1)
    y_pred = nn.forward(x_input)[0][-1]
    predictions.append(y_pred.flatten()[0])

# Unnormalize to compare with the normal
Y_real = np.exp(X)
predictions_real = np.array(predictions) * np.max(Y_real)

# Plot
plt.plot(X, Y_real, label="exp(x)")
plt.plot(X, predictions_real, label="Neural Network", linestyle="--")
plt.legend()
plt.xlabel("x")
plt.ylabel("f(x)")
plt.title("Approximation of exp(x)")
plt.show()