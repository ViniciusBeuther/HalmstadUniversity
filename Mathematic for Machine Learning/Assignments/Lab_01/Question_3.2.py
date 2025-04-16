# calculate the derivatives for the same points and compare them to the results from the numerical derivation
import numpy as np
import sympy as sym

# Numerical derivative 
def numerical_derivative(func, x, delta_x):
    return (func(x + delta_x) - func(x - delta_x)) / (2 * delta_x)

x_sym = sym.symbols('x')



# Calculations for f(x)
f_sym = 5 * x_sym + 2
df_sym = sym.diff(f_sym, x_sym)
f_func = sym.lambdify(x_sym, f_sym, modules=["numpy"])
df_func = sym.lambdify(x_sym, df_sym, modules=["numpy"])



# Calculations for g(x)
g_sym = 6 * x_sym ** 2
dg_sym = sym.diff(g_sym, x_sym)
g_func = sym.lambdify(x_sym, g_sym, modules=["numpy"])
dg_func = sym.lambdify(x_sym, dg_sym, modules=["numpy"])



# Calculations for h(x)
h_sym = sym.cos(2 * x_sym + 6) / sym.exp(6 * x_sym)
dh_sym = sym.diff(h_sym, x_sym)
h_func = sym.lambdify(x_sym, h_sym, modules=["numpy"])
dh_func = sym.lambdify(x_sym, dh_sym, modules=["numpy"])



# initial values for delta and x points
x_points = [1, 2, 3]
delta_x_values = [0.1, 0.01, 0.001]



# show results
def compare_derivatives(name, func, symbolic, points):
    print(f"\n{name}")
    print("-" * 60)
    for x_val in points:
        sym_val = symbolic(x_val)
        print(f"Em x = {x_val}")
        print(f"  Derivada simbólica: {sym_val:.3f}")
        for dx in delta_x_values:
            num_val = numerical_derivative(func, x_val, dx)
            print(f"  Δx = {dx} -> Derivada numérica = {num_val:.3f}")
        print()

# call functions
compare_derivatives("f(x) = 5x + 2", f_func, df_func, x_points)
compare_derivatives("g(x) = 6x ^ 2", g_func, dg_func, x_points)
compare_derivatives("h(x) = cos(2x + 6) / e^(6x)", h_func, dh_func, x_points)
