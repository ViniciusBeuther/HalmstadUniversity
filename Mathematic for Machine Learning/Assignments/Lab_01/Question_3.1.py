import numpy as np
import sympy as sym
import matplotlib.pyplot as plt

# function that calculates numerical derivation
# input arguments: func,delta_x, point (x)
def numerical_derivative(func, x, delta_x):
    return (func(x + delta_x) - func(x - delta_x)) / (2 * delta_x)

def f(x):
    return 5 * x + 2

def g(x):
    return 6 * (x ** 2)

def h(x):
    return sym.cos(2 * x + 6) / np.e ** (6 * x)

# apply the numerical derivation function on the provided functions
delta_x_values = [0.1, 0.01, 0.001]
x_points = [1,2,3]

print("Numerical derivation of f(x) = 5x + 2\n")
for x_val in x_points:
    print(f'On x = {x_val}')
    for delta_x in delta_x_values:
        num_deriv = numerical_derivative(f, x_val, delta_x)
        print(f'  Deltax = {delta_x} -> f\'(x) = {num_deriv:.3f}')
        
print("-" * 50)

print("Numerical derivation of g(x) = 6 * (x ** 2)\n")
for x_val in x_points:
    print(f'On x = {x_val}')
    for delta_x in delta_x_values:
        num_deriv = numerical_derivative(g, x_val, delta_x)
        print(f'  Delta x = {delta_x} -> g\'(x) = {num_deriv:.3f}')

print("-" * 50)

print("Numerical derivation of h(x) = sym.cos(2x + 6) / np.e^6x\n")
for x_val in x_points:
    print(f'On x = {x_val}')
    for delta_x in delta_x_values:
        num_deriv = numerical_derivative(h, x_val, delta_x)
        print(f'  Delta x = {delta_x} -> h\'(x) = {num_deriv:.3f}')