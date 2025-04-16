import numpy as np
import matplotlib.pyplot as plt

# 2.1 Plot the functions
def f(x):
    return np.sin(x) / x

def g(x):
    return 1/(1+ (np.e ** -x))

x = np.arange(-5,5,.2)
#plt.figure(figsize=(10, 6))

plt.plot(x, f(x), 'b', label='f(x)=sin(x) / x')
plt.plot(x, g(x), 'r--', label='g(x)=1/(1+e^(-x))')
plt.legend()
plt.title('f(x) and g(x)')
plt.grid(True)

plt.ylim(-5, 5)
plt.show()