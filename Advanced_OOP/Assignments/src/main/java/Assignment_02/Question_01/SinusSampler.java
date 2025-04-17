package Assignment_02.Question_01;

public class SinusSampler implements Sampler {
    private int t;

    // Calculate the bar value and return it, based on sin(), here is the bar calculation formula
    @Override
    public double getValue(){
        t++;
        return 50 + 50 * Math.sin(t * 0.1);
    }
}
