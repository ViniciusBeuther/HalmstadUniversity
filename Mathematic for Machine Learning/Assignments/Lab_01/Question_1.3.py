# 1.3 Plot the derivatives and the original functions overlaid
import matplotlib.pyplot as plt
import numpy as np

def f(x):
    return 5 * x + 2

def g(x):
    return 6 * (x ** 2)

def h(x):
    return np.cos(2*x + 6) / np.e ** (6*x)

def df(x):
    return 5 * np.ones_like(x)

def dg(x):
    return 12 * x

def dh(x):
    numerator = -2*np.sin(2*x + 6)*np.e**(6*x) - 6*np.cos(2*x + 6)*np.e**(6*x)
    denominator = (np.e**(6*x))**2
    result = numerator / denominator
    
    return result


x = np.linspace(-2,2,300)
plt.figure(figsize=(15, 5))

plt.subplot(1,3,1)

# plot the function and its derivative
plt.plot(x, f(x),'g--', label='f(x) = 5x + 2')
plt.plot(x, df(x),'b--', label='f(x) = 5x + 2')
plt.title('Linear Function')
plt.legend()
plt.grid(True)


# plot g(x) and its derivative
plt.subplot(1, 3, 2)
plt.plot(x, g(x), 'y-', label='g(x) = 6x^2')
plt.plot(x, dg(x), 'g--', label="g'(x) = 12x")
plt.title('Quadratic Function')
plt.legend()
plt.grid(True)


# plot h(x) and its derivative
plt.subplot(1, 3, 3)
plt.plot(x, h(x), 'y-', label='h(x) = cos(2x+6)/e^(6x)')
plt.plot(x, dh(x), 'g--', label="h'(x)")
plt.title('Exponential')
plt.legend()
plt.grid(True)


plt.tight_layout()
plt.show()