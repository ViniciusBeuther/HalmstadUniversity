# 2.2 Calculate their derivatives using sympy
import numpy as np
import sympy as sym
import matplotlib.pyplot as plt

def df(x):
    expression = sym.sin(x) / x
    df_x = sym.diff(expression, x)
    return df_x

def dg(x):
    expression =  1/(1 + (sym.exp(-x)))
    dg_x = sym.diff(expression, x)
    return dg_x

    
x = sym.symbols('x')

print('=== DERIVATIVE CALCULATIONS ===')
print(f'Derivative of f(x): {df(x)}\n')
print(f'Derivative of g(x): {dg(x)}')
